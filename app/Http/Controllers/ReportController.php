<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    // Inventory health report: low stock, days of cover, recent consumption
    public function inventory(Request $request)
    {
        $window = (int) ($request->get('window') ?? 30);
        $window = max(7, min(90, $window));

        $items = Item::with('category')->orderBy('name')->get();

        $summary = [
            'total_items' => $items->count(),
            'total_quantity' => (int) $items->sum('quantity'),
            'low_stock_count' => $items->where(fn($i) => $i->needs_reorder)->count(),
        ];

        // Recent movements
        $from = now()->subDays($window)->startOfDay();
        $recentOut = StockMovement::where('type', 'out')
            ->where('created_at', '>=', $from)
            ->sum('quantity');
        $recentIn = StockMovement::where('type', 'in')
            ->where('created_at', '>=', $from)
            ->sum('quantity');

        // Enrich items with computed metrics
        $items = $items->map(function (Item $item) use ($window) {
            $item->avg_out = $item->averageDailyOut($window);
            $item->cover_days = $item->daysOfCover($window);
            $item->reorder_recommended = $item->recommendedReorderQty(14, 1.2, $window);
            return $item;
        });

        return view('reports.inventory', [
            'items' => $items,
            'summary' => $summary,
            'recentOut' => (int) $recentOut,
            'recentIn' => (int) $recentIn,
            'window' => $window,
        ]);
    }
}