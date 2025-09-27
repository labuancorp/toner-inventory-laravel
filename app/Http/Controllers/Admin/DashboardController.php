<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Category;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin,manager']);
    }

    public function index(Request $request)
    {
        $today = now()->toDateString();

        $metrics = [
            'categories' => Category::count(),
            'items' => Item::count(),
            'stock_in_today' => StockMovement::where('type', 'in')->whereDate('created_at', $today)->sum('quantity'),
            'stock_out_today' => StockMovement::where('type', 'out')->whereDate('created_at', $today)->sum('quantity'),
            'stock_left' => Item::sum('quantity'),
            'need_topup' => Item::whereColumn('quantity', '<=', 'reorder_level')->count(),
            'movements_total' => StockMovement::count(),
        ];

        $lowStockItems = Item::with('category')
            ->whereColumn('quantity', '<=', 'reorder_level')
            ->orderBy('quantity')
            ->limit(8)
            ->get();

        // Build simple timeseries data for last 7 days
        $labels = [];
        $inSeries = [];
        $outSeries = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $labels[] = $date;
            $inSeries[] = (int) StockMovement::where('type', 'in')->whereDate('created_at', $date)->sum('quantity');
            $outSeries[] = (int) StockMovement::where('type', 'out')->whereDate('created_at', $date)->sum('quantity');
        }

        $chartData = compact('labels', 'inSeries', 'outSeries');

        return view('admin.dashboard', compact('metrics', 'lowStockItems', 'chartData'));
    }
}