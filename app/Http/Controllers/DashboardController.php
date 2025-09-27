<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index(Request $request)
    {
        $today = now()->toDateString();

        $stockInToday = StockMovement::where('type', 'in')
            ->whereDate('created_at', $today)
            ->sum('quantity');

        $stockOutToday = StockMovement::where('type', 'out')
            ->whereDate('created_at', $today)
            ->sum('quantity');

        $stockLeft = Item::sum('quantity');

        $needTopupCount = Item::whereColumn('quantity', '<=', 'reorder_level')->count();

        $lowStockItems = Item::with('category')
            ->whereColumn('quantity', '<=', 'reorder_level')
            ->orderBy('quantity')
            ->limit(8)
            ->get();

        $recentMovements = StockMovement::with(['item', 'user'])
            ->latest()
            ->limit(10)
            ->get();

        // Compute simple percentage bars for low stock items
        $lowStockItems->transform(function ($item) {
            $target = max($item->reorder_level, 1);
            $pct = min(100, (int) floor(($item->quantity / $target) * 100));
            $item->progress_pct = $pct;
            return $item;
        });

        return view('dashboard', compact(
            'stockInToday',
            'stockOutToday',
            'stockLeft',
            'needTopupCount',
            'lowStockItems',
            'recentMovements'
        ));
    }
}