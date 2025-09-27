@extends('layouts.material')
@section('title', 'Inventory Dashboard')
@section('content')
    <div class="py-4">
        <div class="container-fluid">
            <!-- Metric cards -->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-3">
                <div class="col">
                    <div class="card">
                        <div class="card-body border-start border-success border-4">
                            <div class="text-sm text-gray-500">Stock In (Today)</div>
                            <div class="mt-1 text-3xl font-bold text-gray-900">{{ number_format($stockInToday) }}</div>
                            <div class="mt-2 progress" aria-label="Stock in progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ min(100, $stockInToday) }}%" aria-valuenow="{{ min(100, $stockInToday) }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body border-start border-danger border-4">
                            <div class="text-sm text-gray-500">Stock Out (Today)</div>
                            <div class="mt-1 text-3xl font-bold text-gray-900">{{ number_format($stockOutToday) }}</div>
                            <div class="mt-2 progress" aria-label="Stock out progress">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: {{ min(100, $stockOutToday) }}%" aria-valuenow="{{ min(100, $stockOutToday) }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body border-start border-primary border-4">
                            <div class="text-sm text-gray-500">Stock Left</div>
                            <div class="mt-1 text-3xl font-bold text-gray-900">{{ number_format($stockLeft) }}</div>
                            <div class="mt-2 progress" aria-label="Stock left progress">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ min(100, max(1, $stockLeft/10)) }}%" aria-valuenow="{{ min(100, max(1, $stockLeft/10)) }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body border-start border-warning border-4">
                            <div class="text-sm text-gray-500">Stock Need Topup</div>
                            <div class="mt-1 text-3xl font-bold text-gray-900">{{ number_format($needTopupCount) }}</div>
                            <div class="mt-2 progress" aria-label="Topup need progress">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: {{ min(100, $needTopupCount * 10) }}%" aria-valuenow="{{ min(100, $needTopupCount * 10) }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Low stock items -->
            <div class="mt-4 row row-cols-1 row-cols-lg-2 g-3">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Items Needing Top-up</h3>
                        </div>
                        <div class="card-body">
                        @if($lowStockItems->isEmpty())
                            <p class="text-gray-500">All items are above reorder levels.</p>
                        @else
                            <ul class="list-unstyled">
                                @foreach($lowStockItems as $i)
                                    <li class="d-flex align-items-center justify-content-between py-2 border-bottom">
                                        <div>
                                            <div class="fw-semibold">{{ $i->name }}</div>
                                            <div class="text-muted small">SKU: {{ $i->sku }} • {{ $i->category->name }}</div>
                                        </div>
                                        <div style="width: 12rem;">
                                            <div class="d-flex align-items-center justify-content-between small text-muted">
                                                <span>Qty: {{ $i->quantity }}</span>
                                                <span>Reorder: {{ $i->reorder_level }}</span>
                                            </div>
                                            <div class="mt-1 progress" aria-label="Item progress">
                                                <div class="progress-bar {{ $i->progress_pct < 50 ? 'bg-danger' : 'bg-warning' }}" role="progressbar" style="width: {{ $i->progress_pct }}%" aria-valuenow="{{ $i->progress_pct }}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="mt-4">
                                <a href="{{ route('items.index', ['q' => '', 'category' => '']) }}" class="btn btn-link">View all items</a>
                            </div>
                        @endif
                        </div>
                    </div>
                </div>

                <!-- Recent movements -->
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Recent Stock Movements</h3>
                        </div>
                        <div class="card-body">
                        @if($recentMovements->isEmpty())
                            <p class="text-gray-500">No movements recorded yet.</p>
                        @else
                            <div>
                                <ul class="list-unstyled">
                                    @foreach($recentMovements as $m)
                                    <li>
                                        <div class="py-3 border-bottom d-flex align-items-start gap-3">
                                            <div class="flex-shrink-0">
                                                @if($m->type === 'in')
                                                    <span class="badge bg-success">IN</span>
                                                @else
                                                    <span class="badge bg-danger">OUT</span>
                                                @endif
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="small">
                                                    <a href="{{ route('items.show', $m->item) }}" class="fw-semibold">{{ $m->item->name }}</a>
                                                </div>
                                                <p class="mb-1 text-muted small">
                                                    {{ $m->quantity }} units • SKU {{ $m->item->sku }}
                                                    @if($m->user)
                                                        • by {{ $m->user->name }}
                                                    @endif
                                                </p>
                                                @if($m->reason)
                                                    <p class="mb-1 text-muted small">Reason: {{ $m->reason }}</p>
                                                @endif
                                                <p class="text-muted small">{{ $m->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick actions -->
            <div class="mt-4 card">
                <div class="card-header">
                    <h3 class="card-title">Quick Actions</h3>
                </div>
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-md-3 g-3">
                        <div class="col">
                            <a href="{{ route('items.index') }}" class="card card-body text-decoration-none">
                                <div class="fw-semibold">Browse Items</div>
                                <div class="text-muted small">Manage and search inventory</div>
                            </a>
                        </div>
                        <div class="col">
                            <a href="{{ route('categories.index') }}" class="card card-body text-decoration-none">
                                <div class="fw-semibold">Manage Categories</div>
                                <div class="text-muted small">Organize inventory by type</div>
                            </a>
                        </div>
                        @can('create', App\Models\Item::class)
                        <div class="col">
                            <a href="{{ route('items.create') }}" class="card card-body text-decoration-none">
                                <div class="fw-semibold">Add New Item</div>
                                <div class="text-muted small">Create new inventory record</div>
                            </a>
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
