@extends('layouts.material')

@section('content')
<div class="win11-space-y-lg">
    {{-- Page Header --}}
    <div class="win11-space-y-sm">
        <h1 class="win11-text-3xl win11-font-semibold win11-tracking-tight">Admin Dashboard</h1>
        <p class="win11-text-secondary">Overview of inventory metrics and recent activity.</p>
    </div>

    {{-- Metric Cards Row --}}
    <div class="win11-grid win11-grid-cols-4 win11-gap-md">
        <div class="win11-card win11-p-xl win11-bg-primary/10">
            <div class="win11-flex win11-items-center win11-justify-between">
                <div>
                    <p class="win11-text-sm win11-text-secondary">Stock Left</p>
                    <p class="win11-text-2xl win11-font-semibold">{{ number_format($metrics['stock_left']) }}</p>
                </div>
                <div class="icon-badge-gradient">
                    <svg class="win11-w-6 win11-h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
            <a href="{{ route('items.index') }}" class="win11-link win11-text-sm win11-mt-2 win11-inline-block">View stock →</a>
        </div>

        <div class="win11-card win11-p-xl win11-bg-warning/10">
            <div class="win11-flex win11-items-center win11-justify-between">
                <div>
                    <p class="win11-text-sm win11-text-secondary">Items Needing Top-up</p>
                    <p class="win11-text-2xl win11-font-semibold win11-text-warning">{{ number_format($metrics['need_topup']) }}</p>
                </div>
                <div class="icon-badge-gradient warm">
                    <svg class="win11-w-6 win11-h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </div>
            </div>
            <a href="{{ route('items.index', ['low' => 1]) }}" class="win11-link win11-text-sm win11-mt-2 win11-inline-block">View low stock →</a>
        </div>

        <div class="win11-card win11-p-xl win11-bg-success/10">
            <div class="win11-flex win11-items-center win11-justify-between">
                <div>
                    <p class="win11-text-sm win11-text-secondary">Stock In (Today)</p>
                    <p class="win11-text-2xl win11-font-semibold win11-text-success">{{ number_format($metrics['stock_in_today']) }}</p>
                </div>
                <div class="icon-badge-gradient accent">
                    <svg class="win11-w-6 win11-h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
            </div>
            <a href="{{ route('items.index', ['action' => 'in']) }}" class="win11-link win11-text-sm win11-mt-2 win11-inline-block">View stock in →</a>
        </div>

        <div class="win11-card win11-p-xl win11-bg-danger/10">
            <div class="win11-flex win11-items-center win11-justify-between">
                <div>
                    <p class="win11-text-sm win11-text-secondary">Stock Out (Today)</p>
                    <p class="win11-text-2xl win11-font-semibold win11-text-danger">{{ number_format($metrics['stock_out_today']) }}</p>
                </div>
                <div class="icon-badge-gradient warm">
                    <svg class="win11-w-6 win11-h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                    </svg>
                </div>
            </div>
            <a href="{{ route('items.index', ['action' => 'out']) }}" class="win11-link win11-text-sm win11-mt-2 win11-inline-block">View stock out →</a>
        </div>
    </div>

    {{-- Charts and Tables Row --}}
    <div class="win11-grid win11-grid-cols-1 lg:win11-grid-cols-3 win11-gap-md">
        {{-- 7-Day Movements Chart --}}
        <div class="lg:win11-col-span-2">
            <div class="win11-card win11-h-full">
                <div class="win11-card-header">
                    <h3 class="win11-text-lg win11-font-semibold">7-Day Stock Movements</h3>
                </div>
                <div class="win11-card-body">
                    <canvas id="movementsChart" height="150"></canvas>
                </div>
            </div>
        </div>

        {{-- Low Stock Items --}}
        <div class="win11-col-span-1">
            <div class="win11-card win11-h-full">
                <div class="win11-card-header">
                    <h3 class="win11-text-lg win11-font-semibold">Low Stock Items</h3>
                </div>

                @if($lowStockItems->isEmpty())
                    <div class="win11-card-body win11-flex win11-flex-col win11-items-center win11-justify-center win11-text-center win11-py-xl">
                        <div class="win11-text-secondary">
                            <svg class="win11-w-16 win11-h-16 win11-mx-auto win11-mb-4 win11-text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p>All items are sufficiently stocked.</p>
                        </div>
                    </div>
                @else
                    <div class="win11-card-body win11-p-0">
                        <div class="win11-space-y-0 win11-max-h-80 win11-overflow-y-auto">
                            @foreach($lowStockItems as $item)
                                <div class="win11-flex win11-items-center win11-justify-between win11-p-md win11-border-b win11-border-divider last:win11-border-b-0 hover:win11-bg-surface-hover">
                                    <div class="win11-flex-1 win11-min-w-0">
                                        <a href="{{ route('items.show', $item) }}" class="win11-link win11-block win11-font-medium win11-truncate">{{ $item->name }}</a>
                                        <div class="win11-text-sm win11-text-secondary win11-truncate">
                                            {{ $item->category->name }} • SKU: {{ $item->sku }}
                                        </div>
                                    </div>
                                    <div class="win11-flex-shrink-0 win11-ml-4">
                                        <span class="win11-badge win11-badge-danger">
                                            {{ $item->quantity }} / {{ $item->reorder_level }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="win11-card-footer win11-text-center">
                        <a href="{{ route('items.index', ['low' => 1]) }}" class="win11-link">View All Low Stock Items</a>
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