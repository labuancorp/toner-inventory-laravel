@extends('layouts.material')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Reorder Suggestions</h4>
                    <a href="{{ route('items.index') }}" class="btn btn-outline-secondary btn-sm">Back to Items</a>
                </div>
                <div class="card-body">
                    @if($items->isEmpty())
                        <p class="text-muted">No items need reordering right now.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-vcenter">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>SKU</th>
                                        <th>Qty</th>
                                        <th>Reorder Level</th>
                                        <th>Recommended Qty</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                        <tr>
                                            <td>
                                                <a href="{{ route('items.show', $item) }}" class="text-decoration-none">{{ $item->name }}</a>
                                            </td>
                                            <td>{{ $item->category->name }}</td>
                                            <td>{{ $item->sku }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ $item->reorder_level }}</td>
                                            <td>{{ $item->recommendedReorderQty(14, 1.2, 30) }}</td>
                                            <td class="text-end">
                                                <form action="{{ route('items.notifyReorder', $item) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button class="btn btn-primary btn-sm">Notify Admins</button>
                                                </form>
                                                <a href="{{ route('items.edit', $item) }}" class="btn btn-link">
                                                    <i class="ti ti-pencil" aria-hidden="true"></i>
                                                    <span class="visually-hidden">Edit</span>
                                                </a>
                                            </td>
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
</div>
@endsection