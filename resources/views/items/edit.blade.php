@extends('layouts.material')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Edit Item</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('items.update', $item) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input name="name" value="{{ old('name', $item->name) }}" class="form-control" required />
                            @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-select" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id', $item->category_id)==$category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">SKU</label>
                                <input name="sku" value="{{ old('sku', $item->sku) }}" class="form-control" required />
                                @error('sku')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Barcode Type</label>
                                <input name="barcode_type" value="{{ old('barcode_type', $item->barcode_type) }}" class="form-control" />
                                @error('barcode_type')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="row g-3 mt-0 mt-md-3">
                            <div class="col-md-6">
                                <label class="form-label">Quantity</label>
                                <input type="number" name="quantity" value="{{ old('quantity', $item->quantity) }}" class="form-control" min="0" required />
                                @error('quantity')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Reorder Level</label>
                                <input type="number" name="reorder_level" value="{{ old('reorder_level', $item->reorder_level) }}" class="form-control" min="0" required />
                                @error('reorder_level')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="row g-3 mt-0 mt-md-3">
                            <div class="col-md-6">
                                <label class="form-label">Location</label>
                                <input name="location" value="{{ old('location', $item->location) }}" class="form-control" />
                                @error('location')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Notes</label>
                                <input name="notes" value="{{ old('notes', $item->notes) }}" class="form-control" />
                                @error('notes')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="row g-3 mt-0 mt-md-3">
                            <div class="col-md-12">
                                <label class="form-label">Image</label>
                                <input type="file" name="image" accept="image/*" class="form-control" />
                                @error('image')<div class="text-danger small">{{ $message }}</div>@enderror
                                @if($item->image_path)
                                    <div class="form-text mt-1">Current image:</div>
                                    <img src="{{ asset('storage/'.$item->image_path) }}" alt="{{ $item->name }}" class="img-thumbnail mt-1" style="max-height: 160px; object-fit: contain;" />
                                    <button class="btn btn-outline-danger btn-sm mt-2" form="removeItemImageForm" onclick="return confirm('Remove current image?')">
                                        <i class="ti ti-trash" aria-hidden="true"></i>
                                        Remove Image
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('items.show', $item) }}" class="btn btn-outline-secondary">Cancel</a>
                            <button class="btn btn-primary">Update</button>
                        </div>
                    </form>
                    @if($item->image_path)
                    <form id="removeItemImageForm" action="{{ route('items.image.destroy', $item) }}" method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection