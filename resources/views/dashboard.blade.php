@extends('layouts.material')
@section('title', 'Inventory Dashboard')
@section('content')
    <div class="win11-py-4">
        <div class="win11-container-fluid">
            <!-- Metric cards -->
            <div class="win11-grid win11-grid-cols-4 win11-gap-lg">
                <div class="win11-stagger-item">
                    <div class="win11-card win11-card-acrylic win11-bg-success/10">
                        <div class="win11-p-xl" style="border-left: 4px solid #107c10;">
                            <div class="win11-text-sm win11-text-secondary">Stock In (Today)</div>
                            <div class="win11-mt-2 win11-text-3xl win11-font-bold win11-text-primary">{{ number_format($stockInToday) }}</div>
                            <div class="win11-mt-3 win11-progress" aria-label="Stock in progress">
                                <div class="win11-progress-bar" style="width: {{ min(100, $stockInToday) }}%; background-color: #107c10;" role="progressbar" aria-valuenow="{{ min(100, $stockInToday) }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="win11-stagger-item">
                    <div class="win11-card win11-card-acrylic win11-bg-danger/10">
                        <div class="win11-p-xl" style="border-left: 4px solid #d13438;">
                            <div class="win11-text-sm win11-text-secondary">Stock Out (Today)</div>
                            <div class="win11-mt-2 win11-text-3xl win11-font-bold win11-text-primary">{{ number_format($stockOutToday) }}</div>
                            <div class="win11-mt-3 win11-progress" aria-label="Stock out progress">
                                <div class="win11-progress-bar" style="width: {{ min(100, $stockOutToday) }}%; background-color: #d13438;" role="progressbar" aria-valuenow="{{ min(100, $stockOutToday) }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="win11-stagger-item">
                    <div class="win11-card win11-card-acrylic win11-bg-primary/10">
                        <div class="win11-p-xl" style="border-left: 4px solid var(--win11-accent-primary);">
                            <div class="win11-text-sm win11-text-secondary">Stock Left</div>
                            <div class="win11-mt-2 win11-text-3xl win11-font-bold win11-text-primary">{{ number_format($stockLeft) }}</div>
                            <div class="win11-mt-3 win11-progress" aria-label="Stock left progress">
                                <div class="win11-progress-bar" style="width: {{ min(100, max(1, $stockLeft/10)) }}%;" role="progressbar" aria-valuenow="{{ min(100, max(1, $stockLeft/10)) }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="win11-stagger-item">
                    <div class="win11-card win11-card-acrylic win11-bg-warning/10">
                        <div class="win11-p-xl" style="border-left: 4px solid #ff8c00;">
                            <div class="win11-text-sm win11-text-secondary">Stock Need Topup</div>
                            <div class="win11-mt-2 win11-text-3xl win11-font-bold win11-text-primary">{{ number_format($needTopupCount) }}</div>
                            <div class="win11-mt-3 win11-progress" aria-label="Topup need progress">
                                <div class="win11-progress-bar" style="width: {{ min(100, $needTopupCount * 10) }}%; background-color: #ff8c00;" role="progressbar" aria-valuenow="{{ min(100, $needTopupCount * 10) }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items Needing Top-up -->
            <div class="win11-grid win11-grid-cols-2 win11-gap-lg win11-mt-lg">
                <div class="win11-stagger-item">
                    <div class="win11-card win11-card-acrylic">
                        <div class="win11-card-header">
                            <h5 class="win11-card-title">Items Needing Top-up</h5>
                        </div>
                        <div class="win11-card-body">
                            @if($lowStockItems->count() === 0)
                                <p class="win11-text-secondary">All items are above reorder levels.</p>
                            @else
                                <div class="win11-list-group">
                                    @foreach($lowStockItems as $i)
                                        <div class="win11-list-item">
                                            <div class="win11-flex win11-justify-between win11-items-start">
                                                <div class="win11-flex-1">
                                                    <div class="win11-font-semibold win11-text-primary">{{ $i->name }}</div>
                                                    <div class="win11-text-sm win11-text-secondary win11-mt-1">SKU: {{ $i->sku }} • {{ $i->category->name }}
                                                        @if($i->needs_reorder)
                                                            <span class="win11-badge win11-badge-warning win11-ml-2">Low stock</span>
                                                        @endif
                                                    </div>
                                                    <div class="win11-mt-2">
                                                        <div class="win11-flex win11-justify-between win11-text-sm win11-text-secondary">
                                                            <span>Qty: {{ $i->quantity }}</span>
                                                            <span>Reorder: {{ $i->reorder_level }}</span>
                                                        </div>
                                                        <div class="win11-progress win11-mt-2" aria-label="Item progress">
                                                            <div class="win11-progress-bar" style="width: {{ $i->progress_pct }}%; background-color: {{ $i->progress_pct < 50 ? '#d13438' : '#ff8c00' }};" role="progressbar" aria-valuenow="{{ $i->progress_pct }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            @if($lowStockItems->hasPages())
                                <div class="win11-mt-3 win11-flex win11-justify-end">
                                    {{ $lowStockItems->withQueryString()->links() }}
                                </div>
                            @endif
                        </div>
                        <div class="win11-card-footer">
                            <a href="{{ route('items.index', ['q' => '', 'category' => '']) }}" class="win11-btn win11-btn-link">View all items</a>
                        </div>
                    </div>
                </div>

                <!-- Recent movements -->
                <div class="win11-stagger-item">
                    <div class="win11-card win11-card-acrylic">
                        <div class="win11-card-header">
                            <h5 class="win11-card-title">Recent Stock Movements</h5>
                        </div>
                        <div class="win11-card-body" style="max-height: 24rem; overflow-y: auto;">
                        @if($recentMovements->isEmpty())
                            <p class="win11-text-secondary">No movements recorded yet.</p>
                        @else
                            <div class="win11-list-group">
                                @foreach($recentMovements as $m)
                                <div class="win11-list-item">
                                    <div class="win11-flex win11-items-start win11-gap-3">
                                        <div class="win11-flex-shrink-0">
                                            @if($m->type === 'in')
                                                <span class="win11-badge win11-badge-success">IN</span>
                                            @else
                                                <span class="win11-badge win11-badge-danger">OUT</span>
                                            @endif
                                        </div>
                                        <div class="win11-flex-1">
                                            <div class="win11-text-sm">
                                                <a href="{{ route('items.show', $m->item) }}" class="win11-font-semibold win11-text-primary">{{ $m->item->name }}</a>
                                            </div>
                                            <div class="win11-text-sm win11-text-secondary win11-mt-1">
                                                {{ $m->quantity }} units • SKU {{ $m->item->sku }}
                                                @if($m->user)
                                                    • by {{ $m->user->name }}
                                                @endif
                                            </div>
                                            @if($m->reason)
                                                <div class="win11-text-sm win11-text-secondary">Reason: {{ $m->reason }}</div>
                                            @endif
                                            <div class="win11-text-sm win11-text-secondary">{{ $m->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif
                        </div>
                        @if($recentMovements instanceof \Illuminate\Pagination\AbstractPaginator && $recentMovements->hasPages())
                        <div class="win11-card-footer">
                            <div class="win11-flex win11-justify-end">
                                {{ $recentMovements->withQueryString()->links() }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick actions -->
            <div class="win11-mt-lg">
                <div class="win11-stagger-item">
                    <div class="win11-card win11-card-acrylic">
                        <div class="win11-card-header">
                            <h5 class="win11-card-title">Quick Actions</h5>
                        </div>
                        <div class="win11-card-body">
                            <div class="win11-grid win11-grid-cols-3 win11-gap-md">
                                <div class="win11-stagger-item">
                                    <a href="{{ route('items.index') }}" class="win11-btn win11-btn-outline win11-w-full win11-h-full win11-flex win11-flex-col win11-items-center win11-justify-center win11-py-lg">
                                        <svg class="win11-icon win11-icon-md win11-mb-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                                            <polyline points="3.27,6.96 12,12.01 20.73,6.96"/>
                                            <line x1="12" y1="22.08" x2="12" y2="12"/>
                                        </svg>
                                        <span>Browse Items</span>
                                    </a>
                                </div>
                                <div class="win11-stagger-item">
                                    <a href="{{ route('categories.index') }}" class="win11-btn win11-btn-outline win11-w-full win11-h-full win11-flex win11-flex-col win11-items-center win11-justify-center win11-py-lg">
                                        <svg class="win11-icon win11-icon-md win11-mb-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                                            <line x1="7" y1="7" x2="7.01" y2="7"/>
                                        </svg>
                                        <span>Manage Categories</span>
                                    </a>
                                </div>
                                @can('create', App\Models\Item::class)
                                    <div class="win11-stagger-item">
                                        <a href="{{ route('items.create') }}" class="win11-btn win11-btn-outline win11-w-full win11-h-full win11-flex win11-flex-col win11-items-center win11-justify-center win11-py-lg">
                                            <svg class="win11-icon win11-icon-md win11-mb-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
