<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\StockMovement;
use App\Models\Item;
use App\Models\Category;

class ShopReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index(Request $request)
    {
        $user = $request->user();

        $periodDays = max(7, min(180, (int) $request->integer('days', 30)));
        $end = now();
        $start = now()->subDays($periodDays);
        $group = $request->get('group', 'daily'); // daily|weekly|monthly
        $categoryId = $request->integer('category_id');

        // Fetch categories for filter
        $categories = Cache::remember('categories.all', 300, fn () => Category::orderBy('name')->get());

        // Base query: user's OUT movements in period
        $movementsQuery = StockMovement::query()
            ->with(['item', 'item.category'])
            ->where('type', 'out')
            ->where('user_id', $user->id)
            ->whereBetween('created_at', [$start, $end]);

        if ($categoryId) {
            $movementsQuery->whereHas('item', function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            });
        }

        $movements = $movementsQuery->orderByDesc('created_at')->paginate(25)->withQueryString();

        // Summary: total usage in period
        $totalUsage = (int) (clone $movementsQuery)->sum('quantity');

        // Timeseries aggregation for chart
        $labels = [];
        $series = [];
        $cursorStart = $start->copy();
        switch ($group) {
            case 'weekly':
                for ($i = 0; $cursorStart->lte($end); $i++, $cursorStart->addWeek()) {
                    $bucketEnd = $cursorStart->copy()->addWeek();
                    $labels[] = $cursorStart->format('Y-m-d');
                    $series[] = (int) (clone $movementsQuery)
                        ->whereBetween('created_at', [$cursorStart, $bucketEnd])
                        ->sum('quantity');
                }
                break;
            case 'monthly':
                for ($i = 0; $cursorStart->lte($end); $i++, $cursorStart->addMonth()) {
                    $bucketEnd = $cursorStart->copy()->addMonth();
                    $labels[] = $cursorStart->format('Y-m');
                    $series[] = (int) (clone $movementsQuery)
                        ->whereBetween('created_at', [$cursorStart, $bucketEnd])
                        ->sum('quantity');
                }
                break;
            default:
                for ($i = 0; $cursorStart->lte($end); $i++, $cursorStart->addDay()) {
                    $bucketEnd = $cursorStart->copy()->addDay();
                    $labels[] = $cursorStart->format('Y-m-d');
                    $series[] = (int) (clone $movementsQuery)
                        ->whereBetween('created_at', [$cursorStart, $bucketEnd])
                        ->sum('quantity');
                }
        }

        // Current stock levels (optionally filtered by category)
        $stockQuery = Item::query()->with('category');
        if ($categoryId) {
            $stockQuery->where('category_id', $categoryId);
        }
        $items = $stockQuery->orderBy('name')->get();
        $lowStockItems = $items->filter(fn ($i) => $i->quantity <= $i->reorder_level);

        $chartData = [
            'labels' => $labels,
            'series' => $series,
        ];

        return view('shop.report', compact(
            'movements',
            'totalUsage',
            'categories',
            'categoryId',
            'periodDays',
            'group',
            'items',
            'lowStockItems',
            'chartData',
        ));
    }

    public function export(Request $request): StreamedResponse
    {
        $user = $request->user();
        $periodDays = max(7, min(180, (int) $request->integer('days', 30)));
        $end = now();
        $start = now()->subDays($periodDays);
        $categoryId = $request->integer('category_id');

        $movementsQuery = StockMovement::query()
            ->with(['item', 'item.category'])
            ->where('type', 'out')
            ->where('user_id', $user->id)
            ->whereBetween('created_at', [$start, $end]);

        if ($categoryId) {
            $movementsQuery->whereHas('item', function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            });
        }

        $movements = $movementsQuery->orderByDesc('created_at')->get();

        $filename = 'personal-usage-' . $user->id . '-' . now()->format('Ymd_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($movements) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Date', 'Item', 'Category', 'Quantity']);
            foreach ($movements as $m) {
                fputcsv($handle, [
                    $m->created_at->toDateTimeString(),
                    optional($m->item)->name,
                    optional(optional($m->item)->category)->name,
                    $m->quantity,
                ]);
            }
            fclose($handle);
        };

        return Response::stream($callback, 200, $headers);
    }
}