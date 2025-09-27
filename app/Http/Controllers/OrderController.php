<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\StockMovement;
use App\Models\User;
use App\Notifications\ReorderAlert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Events\StockAdjusted as StockAdjustedEvent;

class OrderController extends Controller
{
    // Public shop page
    public function index()
    {
        $items = Item::with('category')
            ->orderBy('name')
            ->get();

        return view('public.shop', compact('items'));
    }

    // Handle public order submission
    public function store(Request $request)
    {
        $data = $request->validate([
            'item_id' => ['required', 'exists:items,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'customer_name' => ['nullable', 'string', 'max:120'],
            'notes' => ['nullable', 'string', 'max:255'],
        ]);

        $item = Item::findOrFail($data['item_id']);

        // Ensure sufficient stock
        if ($data['quantity'] > $item->quantity) {
            return back()->withErrors(['quantity' => 'Requested quantity exceeds available stock.'])->withInput();
        }

        // Record stock out movement (public order)
        StockMovement::create([
            'item_id' => $item->id,
            'user_id' => null,
            'type' => 'out',
            'quantity' => (int) $data['quantity'],
            'reason' => 'public_order'.($data['customer_name'] ? ' - '.$data['customer_name'] : ''),
        ]);

        // Adjust item quantity
        $item->decrement('quantity', (int) $data['quantity']);
        $item->refresh();

        // Broadcast stock change
        event(new StockAdjustedEvent($item, $movement));

        // Notify admins if reorder threshold reached
        if ($item->quantity <= $item->reorder_level) {
            $admins = User::where('role', 'admin')->get();
            if ($admins->isNotEmpty()) {
                Notification::send($admins, new ReorderAlert($item));
            }
        }

        return redirect()->route('shop')->with('status', 'Order placed successfully!');
    }
}