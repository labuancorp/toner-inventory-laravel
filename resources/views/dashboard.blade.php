@extends('layouts.material')
@section('title', 'Inventory Dashboard')
@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Metric cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="transform transition-all duration-300 hover:scale-105">
                    <div class="card bg-gradient-to-br from-emerald-50 to-emerald-100 border-l-4 border-emerald-500">
                        <div class="card-body">
                            <div class="text-sm text-emerald-600 font-medium">Stock In (Today)</div>
                            <div class="mt-2 text-3xl font-bold text-emerald-900">{{ number_format($stockInToday) }}</div>
                            <div class="mt-3 progress">
                                <div class="progress-bar bg-emerald-500" style="width: {{ min(100, $stockInToday) }}%;" role="progressbar" aria-valuenow="{{ min(100, $stockInToday) }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="transform transition-all duration-300 hover:scale-105">
                    <div class="card bg-gradient-to-br from-red-50 to-red-100 border-l-4 border-red-500">
                        <div class="card-body">
                            <div class="text-sm text-red-600 font-medium">Stock Out (Today)</div>
                            <div class="mt-2 text-3xl font-bold text-red-900">{{ number_format($stockOutToday) }}</div>
                            <div class="mt-3 progress">
                                <div class="progress-bar bg-red-500" style="width: {{ min(100, $stockOutToday) }}%;" role="progressbar" aria-valuenow="{{ min(100, $stockOutToday) }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="transform transition-all duration-300 hover:scale-105">
                    <div class="card bg-gradient-to-br from-blue-50 to-blue-100 border-l-4 border-blue-500">
                        <div class="card-body">
                            <div class="text-sm text-blue-600 font-medium">Stock Left</div>
                            <div class="mt-2 text-3xl font-bold text-blue-900">{{ number_format($stockLeft) }}</div>
                            <div class="mt-3 progress">
                                <div class="progress-bar bg-blue-500" style="width: {{ min(100, max(1, $stockLeft/10)) }}%;" role="progressbar" aria-valuenow="{{ min(100, max(1, $stockLeft/10)) }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="transform transition-all duration-300 hover:scale-105">
                    <div class="card bg-gradient-to-br from-amber-50 to-amber-100 border-l-4 border-amber-500">
                        <div class="card-body">
                            <div class="text-sm text-amber-600 font-medium">Stock Need Topup</div>
                            <div class="mt-2 text-3xl font-bold text-amber-900">{{ number_format($needTopupCount) }}</div>
                            <div class="mt-3 progress">
                                <div class="progress-bar bg-amber-500" style="width: {{ min(100, $needTopupCount * 10) }}%;" role="progressbar" aria-valuenow="{{ min(100, $needTopupCount * 10) }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items Needing Top-up -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
                <div class="transform transition-all duration-300">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="text-lg font-semibold text-surface-900">Items Needing Top-up</h5>
                        </div>
                        <div class="card-body">
                            @if($lowStockItems->count() === 0)
                                <p class="text-surface-600">All items are above reorder levels.</p>
                            @else
                                <div class="space-y-4">
                                    @foreach($lowStockItems as $i)
                                        <div class="p-4 border border-surface-200 rounded-lg hover:bg-surface-50 transition-colors">
                                            <div class="flex justify-between items-start">
                                                <div class="flex-1">
                                                    <div class="font-semibold text-surface-900">{{ $i->name }}</div>
                                                    <div class="text-sm text-surface-600 mt-1">SKU: {{ $i->sku }} • {{ $i->category->name }}
                                                        @if($i->needs_reorder)
                                                            <span class="badge badge-warning ml-2">Low stock</span>
                                                        @endif
                                                    </div>
                                                    <div class="mt-2">
                                                        <div class="flex justify-between text-sm text-surface-600">
                                                            <span>Qty: {{ $i->quantity }}</span>
                                                            <span>Reorder: {{ $i->reorder_level }}</span>
                                                        </div>
                                                        <div class="progress mt-2">
                                                            <div class="progress-bar {{ $i->progress_pct < 50 ? 'bg-red-500' : 'bg-amber-500' }}" style="width: {{ $i->progress_pct }}%;" role="progressbar" aria-valuenow="{{ $i->progress_pct }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            @if($lowStockItems->hasPages())
                                <div class="mt-4 flex justify-end">
                                    {{ $lowStockItems->withQueryString()->links() }}
                                </div>
                            @endif
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('items.index', ['q' => '', 'category' => '']) }}" class="btn btn-secondary">View all items</a>
                        </div>
                    </div>
                </div>

                <!-- Recent movements -->
                <div class="transform transition-all duration-300">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="text-lg font-semibold text-surface-900">Recent Stock Movements</h5>
                        </div>
                        <div class="card-body max-h-96 overflow-y-auto">
                        @if($recentMovements->isEmpty())
                            <p class="text-surface-600">No movements recorded yet.</p>
                        @else
                            <div class="space-y-3">
                                @foreach($recentMovements as $m)
                                <div class="p-3 border border-surface-200 rounded-lg hover:bg-surface-50 transition-colors">
                                    <div class="flex items-start gap-3">
                                        <div class="flex-shrink-0">
                                            @if($m->type === 'in')
                                                <span class="badge badge-success">IN</span>
                                            @else
                                                <span class="badge badge-danger">OUT</span>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <div class="text-sm">
                                                <a href="{{ route('items.show', $m->item) }}" class="font-semibold text-brand-primary hover:text-blue-700">{{ $m->item->name }}</a>
                                            </div>
                                            <div class="text-sm text-surface-600 mt-1">
                                                {{ $m->quantity }} units • SKU {{ $m->item->sku }}
                                                @if($m->user)
                                                    • by {{ $m->user->name }}
                                                @endif
                                            </div>
                                            @if($m->reason)
                                                <div class="text-sm text-surface-600">Reason: {{ $m->reason }}</div>
                                            @endif
                                            <div class="text-sm text-surface-500">{{ $m->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif
                        </div>
                        @if($recentMovements instanceof \Illuminate\Pagination\AbstractPaginator && $recentMovements->hasPages())
                        <div class="card-footer">
                            <div class="flex justify-end">
                                {{ $recentMovements->withQueryString()->links() }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick actions -->
            <div class="mt-8">
                <div class="transform transition-all duration-300">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="text-lg font-semibold text-surface-900">Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="transform transition-all duration-300 hover:scale-105">
                                    <a href="{{ route('items.index') }}" class="btn btn-secondary w-full h-full flex flex-col items-center justify-center py-8 space-y-2">
                                        <svg class="w-8 h-8 mb-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                                            <polyline points="3.27,6.96 12,12.01 20.73,6.96"/>
                                            <line x1="12" y1="22.08" x2="12" y2="12"/>
                                        </svg>
                                        <span>Browse Items</span>
                                    </a>
                                </div>
                                <div class="transform transition-all duration-300 hover:scale-105">
                                    <a href="{{ route('categories.index') }}" class="btn btn-secondary w-full h-full flex flex-col items-center justify-center py-8 space-y-2">
                                        <svg class="w-8 h-8 mb-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                                            <line x1="7" y1="7" x2="7.01" y2="7"/>
                                        </svg>
                                        <span>Manage Categories</span>
                                    </a>
                                </div>
                                @can('create', App\Models\Item::class)
                                    <div class="transform transition-all duration-300 hover:scale-105">
                                        <a href="{{ route('items.create') }}" class="btn btn-primary w-full h-full flex flex-col items-center justify-center py-8 space-y-2">
                                            <svg class="w-8 h-8 mb-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <line x1="12" y1="5" x2="12" y2="19"/>
                                                <line x1="5" y1="12" x2="19" y2="12"/>
                                            </svg>
                                            <span>Add New Item</span>
                                        </a>
                                    </div>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
