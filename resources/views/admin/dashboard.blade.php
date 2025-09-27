@extends('layouts.material')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header pb-0 d-flex align-items-center justify-content-between">
                <h6 class="mb-0">7-Day Stock Movements</h6>
                <small class="text-secondary">Daily totals for In/Out</small>
            </div>
            <div class="card-body">
                <canvas id="movementsChart" height="120"></canvas>
            </div>
        </div>
    </div>
    <!-- Metrics cards -->
    <div class="col-12 col-md-6 col-xl-3 mb-4">
        <div class="card">
            <div class="card-body">
                <p class="text-sm text-secondary mb-0">Categories</p>
                <h5 class="mb-0">{{ number_format($metrics['categories']) }}</h5>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-xl-3 mb-4">
        <div class="card">
            <div class="card-body">
                <p class="text-sm text-secondary mb-0">Items</p>
                <h5 class="mb-0">{{ number_format($metrics['items']) }}</h5>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-xl-3 mb-4">
        <a href="{{ route('items.index') }}?action=in" class="text-decoration-none">
            <div class="card">
                <div class="card-body">
                    <p class="text-sm text-secondary mb-0">Stock In (Today)</p>
                    <h5 class="mb-0">{{ number_format($metrics['stock_in_today']) }}</h5>
                </div>
            </div>
        </a>
    </div>
    <div class="col-12 col-md-6 col-xl-3 mb-4">
        <a href="{{ route('items.index') }}?action=out" class="text-decoration-none">
            <div class="card">
                <div class="card-body">
                    <p class="text-sm text-secondary mb-0">Stock Out (Today)</p>
                    <h5 class="mb-0">{{ number_format($metrics['stock_out_today']) }}</h5>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12 col-xl-4 mb-4">
        <a href="{{ route('items.index') }}" class="text-decoration-none">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Stock Left</h6>
                </div>
                <div class="card-body">
                    <h2 class="mb-0">{{ number_format($metrics['stock_left']) }}</h2>
                    <p class="text-sm text-secondary">Total units across all items</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-12 col-xl-4 mb-4">
        <a href="{{ route('items.index', ['low' => 1]) }}" class="text-decoration-none">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Need Top-up</h6>
                </div>
                <div class="card-body">
                    <h2 class="mb-0">{{ number_format($metrics['need_topup']) }}</h2>
                    <p class="text-sm text-secondary">Items at or below reorder level</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-12 col-xl-4 mb-4">
        <div class="card">
            <div class="card-header pb-0">
                <h6>Movements Recorded</h6>
            </div>
            <div class="card-body">
                <h2 class="mb-0">{{ number_format($metrics['movements_total']) }}</h2>
                <p class="text-sm text-secondary">Total stock movement events</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header pb-0">
                <h6>Items Needing Top-up</h6>
            </div>
            <div class="card-body">
                @if($lowStockItems->isEmpty())
                    <p class="text-secondary">All items are above reorder levels.</p>
                @else
                    <div class="table-responsive">
                        <table class="table align-items-center">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>SKU</th>
                                    <th>Category</th>
                                    <th>Quantity</th>
                                    <th>Reorder Level</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lowStockItems as $i)
                                    <tr>
                                        <td><a href="{{ route('items.show', $i) }}">{{ $i->name }}</a></td>
                                        <td>{{ $i->sku }}</td>
                                        <td>{{ $i->category->name }}</td>
                                        <td>{{ $i->quantity }}</td>
                                        <td>{{ $i->reorder_level }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<script>
    window.__movementsChartData = @json($chartData ?? null);
</script>
@endsection