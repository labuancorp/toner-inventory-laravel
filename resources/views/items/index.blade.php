@extends('layouts.material')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card card-elevated">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Inventory Items</h4>
                    @can('create', App\Models\Item::class)
                        <a href="{{ route('items.create') }}" class="btn btn-success btn-sm">Add Item</a>
                    @endcan
                </div>

                {{-- Alpine.js component for interactive filtering --}}
                <div
                    class="card-body bg-gradient-card"
                    x-data="{
                        search: '',
                        items: {{ json_encode($items->map(function ($item) {
                            return [
                                'id' => $item->id,
                                'name' => $item->name,
                                'category' => $item->category->name,
                                'sku' => $item->sku,
                                'quantity' => $item->quantity,
                                'reorder_level' => $item->reorder_level,
                                'needs_reorder' => $item->needs_reorder,
                                'show_url' => route('items.show', $item),
                                'edit_url' => route('items.edit', $item),
                            ];
                        })) }},
                        get filteredItems() {
                            if (this.search === '') {
                                return this.items;
                            }
                            return this.items.filter(item =>
                                item.name.toLowerCase().includes(this.search.toLowerCase()) ||
                                item.sku.toLowerCase().includes(this.search.toLowerCase())
                            );
                        }
                    }"
                >
                    <ul class="nav nav-pills mb-3">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('items.index') ? 'active' : '' }}" href="{{ route('items.index') }}">Active</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('items.trashed') ? 'active' : '' }}" href="{{ route('items.trashed') }}">Trashed</a>
                        </li>
                    </ul>

                    {{-- Client-side search input --}}
                    <div class="mb-3">
                        <input
                            x-model="search"
                            type="text"
                            placeholder="Search by name or SKU..."
                            class="form-control"
                            aria-label="Search items"
                        />
                    </div>

                    <div class="table-responsive">
                        <table class="table table-vcenter table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">SKU</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Reorder</th>
                                    <th scope="col" class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Loop through filtered items with Alpine.js --}}
                                <template x-for="item in filteredItems" :key="item.id">
                                    <tr>
                                        <td>
                                            <a :href="item.show_url" class="text-decoration-none" x-text="item.name"></a>
                                            <template x-if="item.needs_reorder">
                                                <span class="badge bg-danger ms-2">Reorder</span>
                                            </template>
                                        </td>
                                        <td x-text="item.category"></td>
                                        <td x-text="item.sku"></td>
                                        <td x-text="item.quantity"></td>
                                        <td x-text="item.reorder_level"></td>
                                        <td class="text-end">
                                            <a :href="item.edit_url" class="btn btn-link">
                                                <i class="ti ti-pencil" aria-hidden="true"></i>
                                                <span class="visually-hidden">Edit</span>
                                            </a>
                                        </td>
                                    </tr>
                                </template>

                                {{-- Message when no results are found --}}
                                <template x-if="filteredItems.length === 0">
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-5">
                                            <i class="ti ti-search-off me-2" aria-hidden="true"></i>
                                            No items found for '<span x-text="search"></span>'.
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection