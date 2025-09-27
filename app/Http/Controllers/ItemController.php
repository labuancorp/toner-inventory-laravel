<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Notifications\ReorderAlert;
use App\Events\StockAdjusted as StockAdjustedEvent;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Item::query()->with('category');
        if ($categoryId = $request->get('category')) {
            $query->where('category_id', $categoryId);
        }
        if ($search = $request->get('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }
        if ($request->boolean('low')) {
            $query->whereColumn('quantity', '<=', 'reorder_level');
        }

        $items = $query->orderBy('name')->paginate(15)->withQueryString();
        $categories = Cache::remember('categories.all', 300, fn () => Category::orderBy('name')->get());
        return view('items.index', compact('items', 'categories'));
    }

    public function create()
    {
        $this->authorize('create', Item::class);
        $categories = Category::orderBy('name')->get();
        return view('items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Item::class);
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required', 'string', 'max:255', 'unique:items,sku'],
            'barcode_type' => ['nullable', 'string', 'max:50'],
            'quantity' => ['required', 'integer', 'min:0'],
            'reorder_level' => ['required', 'integer', 'min:0'],
            'location' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:5120'], // up to 5MB
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
            $data['image_path'] = $path;
        }
        $item = Item::create($data);
        return redirect()->route('items.show', $item)->with('status', 'Item created');
    }

    public function show($id)
    {
        // Include trashed items so they can be viewed from the trash list
        $item = Item::withTrashed()->with('category')->findOrFail($id);
        return view('items.show', compact('item'));
    }

    public function showJson(Item $item)
    {
        $this->authorize('view', $item);
        $item->load('category');
        return response()->json([
            'id' => $item->id,
            'name' => $item->name,
            'sku' => $item->sku,
            'quantity' => (int) $item->quantity,
            'reorder_level' => (int) $item->reorder_level,
            'needs_reorder' => $item->needs_reorder,
            'category' => [
                'id' => $item->category?->id,
                'name' => $item->category?->name,
            ],
        ]);
    }

    public function edit(Item $item)
    {
        $this->authorize('update', $item);
        $categories = Category::orderBy('name')->get();
        return view('items.edit', compact('item', 'categories'));
    }

    public function update(Request $request, Item $item)
    {
        $this->authorize('update', $item);
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required', 'string', 'max:255', "unique:items,sku,{$item->id}"],
            'barcode_type' => ['nullable', 'string', 'max:50'],
            'quantity' => ['required', 'integer', 'min:0'],
            'reorder_level' => ['required', 'integer', 'min:0'],
            'location' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:5120'],
        ]);

        if ($request->hasFile('image')) {
            // Remove old image if present
            if ($item->image_path) {
                Storage::disk('public')->delete($item->image_path);
            }
            $path = $request->file('image')->store('items', 'public');
            $data['image_path'] = $path;
        }
        $item->update($data);
        return redirect()->route('items.show', $item)->with('status', 'Item updated');
    }

    public function destroy(Item $item)
    {
        $this->authorize('delete', $item);
        // With SoftDeletes enabled, this is a soft delete
        $item->delete();
        return redirect()->route('items.index')->with('status', 'Item moved to trash');
    }

    public function destroyImage(Item $item)
    {
        $this->authorize('update', $item);
        if ($item->image_path) {
            Storage::disk('public')->delete($item->image_path);
            $item->image_path = null;
            $item->save();
        }
        return back()->with('status', 'Image removed');
    }

    public function adjustStock(Request $request, Item $item)
    {
        $this->authorize('update', $item);
        $validated = $request->validate([
            'type' => ['required', 'in:in,out'],
            'quantity' => ['required', 'integer', 'min:1'],
            'reason' => ['nullable', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($validated, $item) {
            $movement = new StockMovement([
                'user_id' => auth()->id(),
                'type' => $validated['type'],
                'quantity' => $validated['quantity'],
                'reason' => $validated['reason'] ?? null,
            ]);
            $item->movements()->save($movement);

            if ($validated['type'] === 'in') {
                $item->increment('quantity', $validated['quantity']);
            } else {
                $item->decrement('quantity', $validated['quantity']);
            }

            // Broadcast stock change for real-time updates
            $item->refresh();
            event(new StockAdjustedEvent($item, $movement));
        });

        $item->refresh();
        if ($item->needs_reorder) {
            $admins = User::where('role', 'admin')->get();
            if ($admins->isNotEmpty()) {
                Notification::send($admins, new ReorderAlert($item));
            }
            return back()->with('status', 'Stock adjusted. Reorder alert sent to admins.');
        }

        return back()->with('status', 'Stock adjusted');
    }

    public function trashed()
    {
        $this->authorize('viewAny', Item::class);
        $items = Item::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(15);
        return view('items.trashed', compact('items'));
    }

    public function restore($id)
    {
        $item = Item::onlyTrashed()->findOrFail($id);
        $this->authorize('update', $item);
        $item->restore();
        return redirect()->route('items.show', $item)->with('status', 'Item restored');
    }

    public function reorderSuggestions()
    {
        $this->authorize('viewAny', Item::class);
        $items = Item::with('category')
            ->orderBy('name')
            ->get()
            ->filter(fn(Item $i) => $i->needs_reorder);

        return view('items.reorder', compact('items'));
    }

    public function notifyReorder(Item $item)
    {
        $this->authorize('update', $item);
        $admins = User::where('role', 'admin')->get();
        if ($admins->isNotEmpty()) {
            Notification::send($admins, new ReorderAlert($item));
        }
        return back()->with('status', 'Reorder alert sent to admins.');
    }

    public function scan()
    {
        $this->authorize('viewAny', Item::class);
        return view('items.scan');
    }

    public function lookupBySku($sku)
    {
        $this->authorize('viewAny', Item::class);
        $item = Item::withTrashed()->where('sku', $sku)->firstOrFail();
        return redirect()->route('items.show', $item);
    }
}