@extends('layouts.material')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="mb-0">{{ __('Profile') }}</h5>
        </div>
    </div>
    <div class="col-12 col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">{{ __('Profile Information') }}</h6>
            </div>
            <div class="card-body">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">{{ __('Update Password') }}</h6>
            </div>
            <div class="card-body">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">{{ __('Multi-Factor Authentication') }}</h6>
            </div>
            <div class="card-body">
                <section>
                    <p class="text-sm text-secondary">
                        {{ __('Add a second step to protect access to inventory controls.') }}
                    </p>
                    <form method="post" action="{{ route('mfa.settings.update') }}" class="mt-3">
                        @csrf
                        @method('put')
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="mfa_enabled" name="mfa_enabled" value="1" {{ auth()->user()->mfa_enabled ? 'checked' : '' }}>
                            <label class="form-check-label" for="mfa_enabled">{{ __('Enable email-based Two-Factor Authentication') }}</label>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                        @if (session('status') === 'mfa-enabled')
                            <p class="text-sm text-success mt-2">{{ __('MFA enabled. You will be asked for a code at sign-in.') }}</p>
                        @elseif (session('status') === 'mfa-disabled')
                            <p class="text-sm text-secondary mt-2">{{ __('MFA disabled for your account.') }}</p>
                        @endif
                    </form>
                </section>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">{{ __('Notification Settings') }}</h6>
            </div>
            <div class="card-body">
                @include('profile.partials.notification-settings')
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">{{ __('Delete Account') }}</h6>
            </div>
            <div class="card-body">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection
