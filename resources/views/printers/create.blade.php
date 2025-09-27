@extends('layouts.material')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Add Printer</h4>
                    <a href="{{ route('printers.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('printers.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Name</label>
                                <input name="name" class="form-control" required />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Model</label>
                                <input name="model" class="form-control" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Serial Number</label>
                                <input name="serial_number" class="form-control" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Location</label>
                                <input name="location" class="form-control" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Service Date</label>
                                <input type="date" name="last_service_at" class="form-control" />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Maintenance Interval (months)</label>
                                <input type="number" min="1" max="60" name="maintenance_interval_months" value="6" class="form-control" required />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Image</label>
                                <input type="file" name="image" accept="image/*" class="form-control" />
                                @error('image')<div class="text-danger small">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label">Notes</label>
                                <textarea name="notes" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="mt-3 d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary">Save Printer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection