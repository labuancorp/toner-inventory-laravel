@extends('layouts.material')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Edit Printer</h4>
                    <a href="{{ route('printers.show', $printer) }}" class="btn btn-outline-secondary btn-sm">Back</a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('printers.update', $printer) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Name</label>
                                <input name="name" class="form-control" value="{{ old('name', $printer->name) }}" required />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Model</label>
                                <input name="model" class="form-control" value="{{ old('model', $printer->model) }}" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Serial Number</label>
                                <input name="serial_number" class="form-control" value="{{ old('serial_number', $printer->serial_number) }}" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Location</label>
                                <input name="location" class="form-control" value="{{ old('location', $printer->location) }}" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Service Date</label>
                                <input type="date" name="last_service_at" class="form-control" value="{{ old('last_service_at', optional($printer->last_service_at)->toDateString()) }}" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Maintenance Interval (months)</label>
                                <input type="number" min="1" max="60" name="maintenance_interval_months" value="{{ old('maintenance_interval_months', $printer->maintenance_interval_months) }}" class="form-control" required />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Image</label>
                                <input type="file" name="image" accept="image/*" class="form-control" />
                                @error('image')<div class="text-danger small">{{ $message }}</div>@enderror
                                @if($printer->image_path)
                                    <div class="form-text mt-1">Current image:</div>
                                    <img src="{{ asset('storage/'.$printer->image_path) }}" alt="{{ $printer->name }}" class="img-thumbnail mt-1" style="max-height: 160px; object-fit: contain;" />
                                    <button class="btn btn-outline-danger btn-sm mt-2" form="removePrinterImageForm" onclick="return confirm('Remove current image?')">
                                        <i class="ti ti-trash" aria-hidden="true"></i>
                                        Remove Image
                                    </button>
                                @endif
                            </div>
                            <div class="col-12">
                                <label class="form-label">Notes</label>
                                <textarea name="notes" class="form-control" rows="3">{{ old('notes', $printer->notes) }}</textarea>
                            </div>
                        </div>
                        <div class="mt-3 d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary">Update Printer</button>
                        </div>
                    </form>
                    @if($printer->image_path)
                    <form id="removePrinterImageForm" action="{{ route('printers.image.destroy', $printer) }}" method="POST" class="d-none">
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