@extends('layouts.material')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Trashed Items</h4>
                    <a href="{{ route('items.index') }}" class="btn btn-outline-secondary btn-sm">Back to Items</a>
                </div>
                <div class="card-body">
                    <ul class="nav nav-pills mb-3">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('items.index') ? 'active' : '' }}" href="{{ route('items.index') }}">Active</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('items.trashed') ? 'active' : '' }}" href="{{ route('items.trashed') }}">Trashed</a>
                        </li>
                    </ul>
                    @if($items->isEmpty())
                        <p class="text-muted">No items in trash.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>SKU</th>
                                        <th>Deleted At</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->sku }}</td>
                                            <td>{{ optional($item->deleted_at)->format('Y-m-d H:i') }}</td>
                                            <td class="text-end">
                                                <a href="{{ route('items.show', $item) }}" class="btn btn-link">
                                                    <i class="ti ti-eye" aria-hidden="true"></i>
                                                    <span class="visually-hidden">View</span>
                                                </a>
                                                <form action="{{ route('items.restore', $item->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button class="btn btn-primary btn-sm">Restore</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $items->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection