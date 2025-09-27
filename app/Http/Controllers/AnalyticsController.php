<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index(Request $request)
    {
        $window = (int) ($request->get('window') ?? 30);
        $window = max(7, min(180, $window));

        // Build timeseries for last N days
        $labels = [];
        $inSeries = [];
        $outSeries = [];
        for ($i = $window - 1; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $labels[] = $date;
            $inSeries[] = (int) StockMovement::where('type', 'in')->whereDate('created_at', $date)->sum('quantity');
            $outSeries[] = (int) StockMovement::where('type', 'out')->whereDate('created_at', $date)->sum('quantity');
        }

        $timeseries = compact('labels', 'inSeries', 'outSeries');

        // Category distribution by current quantity
        $categories = Category::orderBy('name')->get();
        $categoryLabels = $categories->pluck('name')->all();
        $categoryQuantities = $categories->map(function (Category $c) {
            return (int) Item::where('category_id', $c->id)->sum('quantity');
        })->all();
        $categoryDistribution = [
            'labels' => $categoryLabels,
            'series' => $categoryQuantities,
        ];

        // Fast movers (top OUT quantities in window)
        $from = now()->subDays($window)->startOfDay();
        $fastMovers = StockMovement::selectRaw('item_id, SUM(quantity) as total_out')
            ->where('type', 'out')
            ->where('created_at', '>=', $from)
            ->groupBy('item_id')
            ->orderByDesc('total_out')
            ->limit(10)
            ->get()
            ->map(function ($row) {
                $item = Item::withTrashed()->find($row->item_id);
                return [
                    'item' => $item,
                    'total_out' => (int) $row->total_out,
                ];
            });

        // ABC classification based on OUT in window
        $byItem = StockMovement::selectRaw('item_id, SUM(quantity) as total_out')
            ->where('type', 'out')
            ->where('created_at', '>=', $from)
            ->groupBy('item_id')
            ->orderByDesc('total_out')
            ->get();

        $totalOutAll = max(1, (int) $byItem->sum('total_out'));
        $cumPct = 0.0;
        $abcCounts = ['A' => 0, 'B' => 0, 'C' => 0];
        foreach ($byItem as $row) {
            $pct = ((int) $row->total_out) / $totalOutAll;
            $cumPct += $pct;
            if ($cumPct <= 0.8) {
                $abcCounts['A']++;
            } elseif ($cumPct <= 0.95) {
                $abcCounts['B']++;
            } else {
                $abcCounts['C']++;
            }
        }

        $summary = [
            'total_items' => Item::count(),
            'total_quantity' => (int) Item::sum('quantity'),
            'low_stock_count' => Item::whereColumn('quantity', '<=', 'reorder_level')->count(),
            'abc' => $abcCounts,
        ];

        return view('reports.analytics', [
            'window' => $window,
            'summary' => $summary,
            'timeseries' => $timeseries,
            'categoryDistribution' => $categoryDistribution,
            'fastMovers' => $fastMovers,
        ]);
    }

    public function yearly(Request $request)
    {
        $year = (int) ($request->get('year') ?? now()->year);
        $year = max(2000, min(2099, $year));
        $from = now()->setYear($year)->startOfYear();
        $to = now()->setYear($year)->endOfYear();

        $rows = DB::table('stock_movements as sm')
            ->join('items as i', 'i.id', '=', 'sm.item_id')
            ->join('categories as c', 'c.id', '=', 'i.category_id')
            ->where('sm.type', 'out')
            ->whereBetween('sm.created_at', [$from, $to])
            ->groupBy('c.id', 'c.name')
            ->selectRaw('c.id as category_id, c.name as category_name, SUM(sm.quantity) as total_out')
            ->orderByDesc('total_out')
            ->get();

        $totalOutYear = (int) $rows->sum('total_out');
        $labels = $rows->pluck('category_name')->all();
        $series = $rows->pluck('total_out')->map(fn($v) => (int) $v)->all();

        return view('reports.analytics_yearly', [
            'year' => $year,
            'labels' => $labels,
            'series' => $series,
            'rows' => $rows,
            'totalOutYear' => $totalOutYear,
        ]);
    }

    public function exportYearly(Request $request)
    {
        $year = (int) ($request->get('year') ?? now()->year);
        $year = max(2000, min(2099, $year));
        $from = now()->setYear($year)->startOfYear();
        $to = now()->setYear($year)->endOfYear();

        $rows = DB::table('stock_movements as sm')
            ->join('items as i', 'i.id', '=', 'sm.item_id')
            ->join('categories as c', 'c.id', '=', 'i.category_id')
            ->where('sm.type', 'out')
            ->whereBetween('sm.created_at', [$from, $to])
            ->groupBy('c.id', 'c.name')
            ->selectRaw('c.name as category_name, SUM(sm.quantity) as total_out')
            ->orderByDesc('total_out')
            ->get();

        $filename = "yearly_out_by_category_{$year}.csv";
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($rows, $year) {
            $out = fopen('php://output', 'w');
            // BOM for Excel to properly read UTF-8
            fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($out, ["Category", "Total OUT ({$year})"], ',');
            foreach ($rows as $r) {
                fputcsv($out, [$r->category_name, (int) $r->total_out], ',');
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }
}