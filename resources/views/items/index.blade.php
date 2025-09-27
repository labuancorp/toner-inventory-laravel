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
                <div class="card-body bg-gradient-card">
                    <ul class="nav nav-pills mb-3">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('items.index') ? 'active' : '' }}" href="{{ route('items.index') }}">Active</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('items.trashed') ? 'active' : '' }}" href="{{ route('items.trashed') }}">Trashed</a>
                        </li>
                    </ul>
                    <div class="mb-3">
                        <form method="GET" class="row g-2 align-items-center">
                            <div class="col-md-3">
                                <select name="category" class="form-select">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" @selected(request('category')==$category->id)>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search by name or SKU" class="form-control" />
                            </div>
                            <div class="col-md-3 text-end">
                                <button class="btn btn-primary">Filter</button>
                            </div>
                        </form>
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
                                @forelse($items as $item)
                                    <tr>
                                        <td>
                                            <a href="{{ route('items.show', $item) }}" class="text-decoration-none">{{ $item->name }}</a>
                                            @if($item->needs_reorder)
                                                <span class="badge bg-danger ms-2">Reorder</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->category->name }}</td>
                                        <td>{{ $item->sku }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ $item->reorder_level }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('items.edit', $item) }}" class="btn btn-link">
                                                <i class="ti ti-pencil" aria-hidden="true"></i>
                                                <span class="visually-hidden">Edit</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-5">
                                            <i class="ti ti-box-off me-2" aria-hidden="true"></i>
                                            No items found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">{{ $items->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection