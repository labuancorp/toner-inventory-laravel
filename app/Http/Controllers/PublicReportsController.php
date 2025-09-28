<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockMovement;

class PublicReportsController extends Controller
{
    /**
     * Show aggregated usage reports for standard users without inventory details.
     */
    public function index(Request $request)
    {
        $window = (int)($request->input('window', 30));
        if ($window < 7 || $window > 180) {
            $window = 30;
        }

        $start = now()->subDays($window);

        // Aggregate OUT movements by category, avoiding item-level inventory exposure
        $byCategory = StockMovement::selectRaw('categories.name as category_name, SUM(stock_movements.quantity) as total_out')
            ->join('items', 'stock_movements.item_id', '=', 'items.id')
            ->join('categories', 'items.category_id', '=', 'categories.id')
            ->where('stock_movements.type', 'out')
            ->where('stock_movements.created_at', '>=', $start)
            ->groupBy('categories.name')
            ->orderByDesc('total_out')
            ->get();

        $labels = $byCategory->pluck('category_name')->values();
        $series = $byCategory->pluck('total_out')->map(fn($n) => (int) $n)->values();
        $totalOut = (int) $byCategory->sum('total_out');

        return view('reports.public', [
            'window'      => $window,
            'totalOut'    => $totalOut,
            'byCategory'  => $byCategory,
            'chart'       => [
                'labels' => $labels,
                'series' => $series,
            ],
        ]);
    }
}