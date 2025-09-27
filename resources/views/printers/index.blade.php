@extends('layouts.material')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Printers</h4>
                    <div class="d-flex gap-2 align-items-center">
                        <form method="GET" action="{{ route('printers.index') }}" class="d-flex gap-2">
                            <input type="text" name="location" value="{{ request('location') }}" placeholder="Filter by location" class="form-control form-control-sm" style="max-width: 220px" />
                            <button class="btn btn-outline-secondary btn-sm" type="submit">Filter</button>
                            <a href="{{ route('printers.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
                        </form>
                        <a href="{{ route('printers.docs') }}" class="btn btn-outline-info btn-sm">Setup & Maintenance Guide</a>
                        <form method="POST" action="{{ route('printers.notifyDue') }}">
                            @csrf
                            <button class="btn btn-outline-warning btn-sm" type="submit">Notify Admins: Due</button>
                        </form>
                        <a href="{{ route('printers.create') }}" class="btn btn-success btn-sm">Add Printer</a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-info" role="alert">{{ session('status') }}</div>
                    @endif
                    @if($printers->isEmpty())
                        <p class="text-muted">No printers added yet.</p>
                    @else
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Model</th>
                                        <th>Serial</th>
                                        <th>Location</th>
                                        <th>Last Service</th>
                                        <th>Interval (months)</th>
                                        <th>Next Due</th>
                                        <th>Status</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($printers as $printer)
                                        @php($next = $printer->nextDueAt())
                                        <tr>
                                            <td style="width:80px">
                                                @if($printer->image_path)
                                                    <img src="{{ asset('storage/'.$printer->image_path) }}" alt="{{ $printer->name }}" class="img-thumbnail" style="max-height: 60px; object-fit: contain;" />
                                                @else
                                                    <span class="text-muted small">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('printers.show', $printer) }}" class="text-decoration-none">{{ $printer->name }}</a>
                                            </td>
                                            <td>{{ $printer->model }}</td>
                                            <td>{{ $printer->serial_number }}</td>
                                            <td>{{ $printer->location }}</td>
                                            <td>{{ optional($printer->last_service_at)->toDateString() ?? '—' }}</td>
                                            <td>{{ $printer->maintenance_interval_months }}</td>
                                            <td>{{ $next?->toDateString() ?? '—' }}</td>
                                            <td>
                                                @if($printer->is_due)
                                                    <span class="badge bg-danger">Due</span>
                                                @elseif(! $next)
                                                    <span class="badge bg-secondary">Unset</span>
                                                @else
                                                    @php($days = $printer->days_until_due)
                                                    <span class="badge bg-info">In {{ $days }} days</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <form method="POST" action="{{ route('printers.service', $printer) }}" class="d-inline">
                                                    @csrf
                                                    <button class="btn btn-primary btn-sm" type="submit">Mark Serviced</button>
                                                </form>
                                                <a href="{{ route('printers.edit', $printer) }}" class="btn btn-outline-secondary btn-sm">Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div>
                            {{ $printers->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
 </div>
@endsection