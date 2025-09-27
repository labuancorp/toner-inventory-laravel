@extends('layouts.material')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-6 col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header text-center">
                <a href="{{ url('/') }}" class="text-decoration-none">{{ config('app.name', 'Laravel') }}</a>
            </div>
            <div class="card-body">
                {{ $slot }}
            </div>
        </div>
    </div>
 </div>
@endsection
