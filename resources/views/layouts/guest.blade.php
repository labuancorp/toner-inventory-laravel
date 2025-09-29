@extends('layouts.material')

@section('content')
@php($isRegister = request()->routeIs('register'))
<div class="row justify-content-center w-100">
    <div class="{{ $isRegister ? 'col-12 col-sm-11 col-md-10 col-lg-9 col-xl-8' : 'col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5' }}">
        <div class="card shadow-sm w-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <a href="{{ url('/') }}" class="text-decoration-none">{{ config('app.name', 'Laravel') }}</a>
                <div class="ms-2 d-flex align-items-center">
                    <x-theme-toggle />
                    <x-language-switcher />
                </div>
            </div>
            <div class="card-body p-3 p-md-4">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
@endsection
