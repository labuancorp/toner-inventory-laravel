<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ShopHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    protected function baseQuery(Request $request)
    {
        $query = StockMovement::query()
            ->with(['item', 'item.category', 'user'])
            ->orderByDesc('created_at');

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        if (!empty($startDate)) {
            $query->where('created_at', '>=', \Carbon\Carbon::parse($startDate)->startOfDay());
        }
        if (!empty($endDate)) {
            $query->where('created_at', '<=', \Carbon\Carbon::parse($endDate)->endOfDay());
        }

        if ($userId = $request->integer('user_id')) {
            $query->where('user_id', $userId);
        }
        if ($categoryId = $request->integer('category_id')) {
            $query->whereHas('item', function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            });
        }
        if ($itemId = $request->integer('item_id')) {
            $query->where('item_id', $itemId);
        }

        return $query;
    }

    public function index(Request $request)
    {
        $users = User::orderBy('name')->get(['id', 'name']);
        $categories = Category::orderBy('name')->get(['id', 'name']);
        $items = Item::orderBy('name')->get(['id', 'name']);

        $movements = $this->baseQuery($request)->paginate(50)->withQueryString();

        $total = (clone $this->baseQuery($request))->count();
        $totalOut = (int) (clone $this->baseQuery($request))->where('type', 'out')->sum('quantity');
        $totalIn = (int) (clone $this->baseQuery($request))->where('type', 'in')->sum('quantity');

        return view('shop.history', compact(
            'movements',
            'users',
            'categories',
            'items',
            'total',
            'totalOut',
            'totalIn'
        ));
    }

    public function export(Request $request)
    {
        $filename = 'toner_history_' . now()->format('Ymd_His') . '.csv';

        $response = new StreamedResponse(function () use ($request) {
            $handle = fopen('php://output', 'w');
            // Header row
            fputcsv($handle, ['Date', 'Time', 'User', 'Toner', 'SKU', 'Category', 'Quantity', 'Type', 'Reason']);

            $this->baseQuery($request)->chunk(500, function ($rows) use ($handle) {
                foreach ($rows as $m) {
                    $date = optional($m->created_at)->toDateString();
                    $time = optional($m->created_at)->format('H:i:s');
                    $user = optional($m->user)->name;
                    $item = optional($m->item)->name;
                    $sku = optional($m->item)->sku;
                    $category = optional(optional($m->item)->category)->name;
                    $quantity = (int) $m->quantity;
                    $type = $m->type;
                    $reason = (string) ($m->reason ?? '');
                    fputcsv($handle, [$date, $time, $user, $item, $sku, $category, $quantity, $type, $reason]);
                }
            });

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }
}