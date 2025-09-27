@extends('layouts.material')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Printer Setup & Maintenance Guide</h4>
                    <a href="{{ route('printers.index') }}" class="btn btn-outline-secondary btn-sm">Back to Printers</a>
                </div>
                <div class="card-body">
                    <p class="text-muted">Use this guide to set up printers, upload images, and keep maintenance schedules accurate.</p>

                    <h5 class="mt-3">1) Add a Printer</h5>
                    <ul>
                        <li>Go to <a href="{{ route('printers.index') }}">Printers</a> and click <strong>Add Printer</strong>.</li>
                        <li>Fill in <strong>Name</strong>, <strong>Model</strong>, <strong>Serial Number</strong>, and <strong>Location</strong>.</li>
                        <li>Set <strong>Last Service Date</strong> and the <strong>Maintenance Interval</strong> (months).</li>
                        <li>Optionally upload a <strong>device image</strong> for visual identification.</li>
                    </ul>

                    <h5 class="mt-4">2) Upload or Update Device Image</h5>
                    <ul>
                        <li>On the printer <strong>Edit</strong> page, use the Image field to upload a photo.</li>
                        <li>Use the <strong>Remove Image</strong> button to clear the current image.</li>
                        <li>Supported formats: JPG, PNG, GIF. Max size: 5 MB.</li>
                    </ul>

                    <h5 class="mt-4">3) Maintenance Status</h5>
                    <ul>
                        <li>Status badges show <strong>Due</strong>, <strong>Unset</strong>, or <strong>In N days</strong> based on interval and last service date.</li>
                        <li>Click <strong>Mark Serviced</strong> to record maintenance and reset the schedule.</li>
                    </ul>

                    <h5 class="mt-4">4) Automated Notifications</h5>
                    <ul>
                        <li>Admins receive automatic notifications each morning for printers due for maintenance.</li>
                        <li>You can also send notifications on demand from the <strong>Printers</strong> list or a printer’s <strong>Details</strong> page.</li>
                    </ul>

                    <div class="mt-4 p-3 bg-light border rounded">
                        <div class="fw-semibold">Tips</div>
                        <ul class="mb-0">
                            <li>Use consistent <strong>Location</strong> names to make filtering and grouping easier.</li>
                            <li>Upload clear, front-facing photos to quickly identify devices onsite.</li>
                            <li>Set realistic intervals (e.g., 6 months) based on manufacturer guidance.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection