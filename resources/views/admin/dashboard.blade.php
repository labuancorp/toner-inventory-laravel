@extends('layouts.material')

@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div class="space-y-2">
        <h1 class="text-3xl font-semibold tracking-tight text-gray-900 dark:text-gray-100">Admin Dashboard</h1>
        <p class="text-gray-600 dark:text-gray-400">Overview of inventory metrics and recent activity.</p>
    </div>

    {{-- Metric Cards Row --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6 bg-blue-50 dark:bg-blue-900/20">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Stock Left</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ number_format($metrics['stock_left']) }}</p>
                </div>
                <div class="icon-badge-gradient">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
            <a href="{{ route('items.index') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 underline text-sm mt-2 inline-block">View stock →</a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6 bg-yellow-50 dark:bg-yellow-900/20">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Items Needing Top-up</p>
                    <p class="text-2xl font-semibold text-yellow-600 dark:text-yellow-400">{{ number_format($metrics['need_topup']) }}</p>
                </div>
                <div class="icon-badge-gradient warm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </div>
            </div>
            <a href="{{ route('items.index', ['low' => 1]) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 underline text-sm mt-2 inline-block">View low stock →</a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6 bg-green-50 dark:bg-green-900/20">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Stock In (Today)</p>
                    <p class="text-2xl font-semibold text-green-600 dark:text-green-400">{{ number_format($metrics['stock_in_today']) }}</p>
                </div>
                <div class="icon-badge-gradient accent">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
            </div>
            <a href="{{ route('items.index', ['action' => 'in']) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 underline text-sm mt-2 inline-block">View stock in →</a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6 bg-red-50 dark:bg-red-900/20">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Stock Out (Today)</p>
                    <p class="text-2xl font-semibold text-red-600 dark:text-red-400">{{ number_format($metrics['stock_out_today']) }}</p>
                </div>
                <div class="icon-badge-gradient warm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                    </svg>
                </div>
            </div>
            <a href="{{ route('items.index', ['action' => 'out']) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 underline text-sm mt-2 inline-block">View stock out →</a>
        </div>
    </div>

    {{-- Charts and Tables Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        {{-- 7-Day Movements Chart --}}
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 h-full">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">7-Day Stock Movements</h3>
                </div>
                <div class="p-6">
                    <canvas id="movementsChart" height="150"></canvas>
                </div>
            </div>
        </div>

        {{-- Low Stock Items --}}
        <div class="col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 h-full">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Low Stock Items</h3>
                </div>

                @if($lowStockItems->isEmpty())
                    <div class="p-6 flex flex-col items-center justify-center text-center py-12">
                        <div class="text-gray-600 dark:text-gray-400">
                            <svg class="w-16 h-16 mx-auto mb-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p>All items are sufficiently stocked.</p>
                        </div>
                    </div>
                @else
                    <div class="p-0">
                        <div class="space-y-0 max-h-80 overflow-y-auto">
                            @foreach($lowStockItems as $item)
                                <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700 last:border-b-0 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <div class="flex-1 min-w-0">
                                        <a href="{{ route('items.show', $item) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 underline block font-medium truncate">{{ $item->name }}</a>
                                        <div class="text-sm text-gray-600 dark:text-gray-400 truncate">
                                            {{ $item->category->name }} • SKU: {{ $item->sku }}
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 ml-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                            {{ $item->quantity }} / {{ $item->reorder_level }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 text-center">
                        <a href="{{ route('items.index', ['low' => 1]) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 underline">View All Low Stock Items</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    // Pass chart data to the material.js script
    window.__movementsChartData = @json($chartData ?? null);
</script>
@endsection