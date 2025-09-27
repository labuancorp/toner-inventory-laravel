@extends('layouts.material')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Categories</h4>
                    @can('create', App\Models\Category::class)
                        <a href="{{ route('categories.create') }}" class="btn btn-success btn-sm">Add Category</a>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-vcenter table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Slug</th>
                                    <th scope="col">Description</th>
                                    <th scope="col" class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->slug }}</td>
                                        <td>{{ $category->description }}</td>
                                        <td class="text-end">
                                            @can('update', $category)
                                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-link">
                                                    <i class="ti ti-pencil" aria-hidden="true"></i>
                                                    <span class="visually-hidden">Edit</span>
                                                </a>
                                            @endcan
                                            @can('delete', $category)
                                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-link text-danger">
                                                    <i class="ti ti-trash" aria-hidden="true"></i>
                                                    <span class="visually-hidden">Delete</span>
                                                </button>
                                            </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-5">
                                            <i class="ti ti-folders me-2" aria-hidden="true"></i>
                                            No categories found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $categories->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection