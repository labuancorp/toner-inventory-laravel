@extends('layouts.material')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-xl-7">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Printer Details</h4>
                    <div class="d-flex gap-2">
                        <a href="{{ route('printers.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
                        <a href="{{ route('printers.edit', $printer) }}" class="btn btn-outline-primary btn-sm">Edit</a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-info" role="alert">{{ session('status') }}</div>
                    @endif
                    @if($printer->image_path)
                        <div class="mb-4 text-center">
                            <img src="{{ asset('storage/'.$printer->image_path) }}" alt="{{ $printer->name }}" class="img-fluid rounded border" style="max-height: 240px; object-fit: contain;" />
                            <form action="{{ route('printers.image.destroy', $printer) }}" method="POST" class="mt-2 d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm" onclick="return confirm('Remove current image?')">Delete Image</button>
                            </form>
                        </div>
                    @endif
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="fw-semibold">Name</div>
                            <div>{{ $printer->name }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="fw-semibold">Model</div>
                            <div>{{ $printer->model }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="fw-semibold">Serial Number</div>
                            <div>{{ $printer->serial_number }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="fw-semibold">Location</div>
                            <div>{{ $printer->location }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="fw-semibold">Last Service</div>
                            <div>{{ optional($printer->last_service_at)->toDateString() ?? '—' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="fw-semibold">Maintenance Interval</div>
                            <div>{{ $printer->maintenance_interval_months }} months</div>
                        </div>
                        @php($next = $printer->nextDueAt())
                        <div class="col-md-6">
                            <div class="fw-semibold">Next Due</div>
                            <div>{{ $next?->toDateString() ?? '—' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="fw-semibold">Status</div>
                            <div>
                                @if($printer->is_due)
                                    <span class="badge bg-danger">Due</span>
                                @elseif(! $next)
                                    <span class="badge bg-secondary">Unset</span>
                                @else
                                    <span class="badge bg-info">In {{ $printer->days_until_due }} days</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="fw-semibold">Notes</div>
                            <div class="text-muted">{{ $printer->notes }}</div>
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <form method="POST" action="{{ route('printers.service', $printer) }}">
                            @csrf
                            <button class="btn btn-primary" type="submit">Mark Serviced</button>
                        </form>
                        <form method="POST" action="{{ route('printers.notifyDue') }}">
                            @csrf
                            <button class="btn btn-outline-warning" type="submit">Notify Admins</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection