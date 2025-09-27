@extends('layouts.material')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Create Item</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input name="name" value="{{ old('name') }}" class="form-control" required />
                            @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-select" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id')==$category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">SKU</label>
                                <input name="sku" value="{{ old('sku') }}" class="form-control" required />
                                @error('sku')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Barcode Type</label>
                                <input name="barcode_type" value="{{ old('barcode_type', 'CODE_128') }}" class="form-control" />
                                @error('barcode_type')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="row g-3 mt-0 mt-md-3">
                            <div class="col-md-6">
                                <label class="form-label">Quantity</label>
                                <input type="number" name="quantity" value="{{ old('quantity', 0) }}" class="form-control" min="0" required />
                                @error('quantity')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Reorder Level</label>
                                <input type="number" name="reorder_level" value="{{ old('reorder_level', 0) }}" class="form-control" min="0" required />
                                @error('reorder_level')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="row g-3 mt-0 mt-md-3">
                            <div class="col-md-6">
                                <label class="form-label">Location</label>
                                <input name="location" value="{{ old('location') }}" class="form-control" />
                                @error('location')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Notes</label>
                                <input name="notes" value="{{ old('notes') }}" class="form-control" />
                                @error('notes')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="row g-3 mt-0 mt-md-3">
                            <div class="col-md-12">
                                <label class="form-label">Image</label>
                                <input type="file" name="image" accept="image/*" class="form-control" />
                                @error('image')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('items.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection