@extends('layouts.material')

@section('content')
{{-- Page Header --}}
<div class="page-header d-print-none mb-4">
    <div class="row align-items-center">
        <div class="col">
            <h2 class="page-title">
                Admin Dashboard
            </h2>
            <div class="text-muted mt-1">
                Overview of inventory metrics and recent activity.
            </div>
        </div>
    </div>
</div>

{{-- Metric Cards Row --}}
<div class="row row-deck row-cards mb-4">
    <div class="col-sm-6 col-lg-3">
        <x-info-card
            title="Total Items"
            :value="number_format($metrics['items'])"
            icon="box"
            :href="route('items.index')"
        />
    </div>
    <div class="col-sm-6 col-lg-3">
        <x-info-card
            title="Items Needing Top-up"
            :value="number_format($metrics['need_topup'])"
            icon="alert-triangle"
            :href="route('items.index', ['low' => 1])"
        />
    </div>
    <div class="col-sm-6 col-lg-3">
        <x-info-card
            title="Stock In (Today)"
            :value="number_format($metrics['stock_in_today'])"
            icon="trending-up"
            :href="route('items.index', ['action' => 'in'])"
        />
    </div>
    <div class="col-sm-6 col-lg-3">
        <x-info-card
            title="Stock Out (Today)"
            :value="number_format($metrics['stock_out_today'])"
            icon="trending-down"
            :href="route('items.index', ['action' => 'out'])"
        />
    </div>
</div>

{{-- Charts and Tables Row --}}
<div class="row row-deck row-cards">
    {{-- 7-Day Movements Chart --}}
    <div class="col-lg-8 mb-4 mb-lg-0">
        <div class="card h-100">
            <div class="card-header">
                <h3 class="card-title">7-Day Stock Movements</h3>
            </div>
            <div class="card-body">
                <canvas id="movementsChart" height="150"></canvas>
            </div>
        </div>
    </div>

    {{-- Low Stock Items --}}
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <h3 class="card-title">Low Stock Items</h3>
            </div>

            @if($lowStockItems->isEmpty())
                <div class="card-body text-center d-flex flex-column justify-content-center">
                    <div class="text-muted">
                        <i class="ti ti-circle-check" style="font-size: 3rem;"></i>
                        <p class="mt-2">All items are sufficiently stocked.</p>
                    </div>
                </div>
            @else
                <div class="list-group list-group-flush list-group-hoverable overflow-auto" style="max-height: 350px;">
                    @foreach($lowStockItems as $item)
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col text-truncate">
                                    <a href="{{ route('items.show', $item) }}" class="text-reset d-block">{{ $item->name }}</a>
                                    <div class="d-block text-muted text-truncate mt-n1">
                                        {{ $item->category->name }} &bull; SKU: {{ $item->sku }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <span class="badge bg-danger-lt">
                                        {{ $item->quantity }} / {{ $item->reorder_level }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            @if($lowStockItems->isNotEmpty())
            <div class="card-footer text-center">
                <a href="{{ route('items.index', ['low' => 1]) }}">View All Low Stock Items</a>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Pass chart data to the material.js script
    window.__movementsChartData = @json($chartData ?? null);
</script>
@endsection