@extends('layouts.material')

@section('content')
<div class="container mx-auto px-6">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <h5 class="text-xl font-semibold flex items-center">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                {{ __('Profile') }}
            </h5>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-surface-200 hover:shadow-md transition-shadow duration-200">
            <div class="px-6 py-4 border-b border-surface-200">
                <h6 class="text-lg font-semibold flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ __('Profile Information') }}
                </h6>
            </div>
            <div class="p-6">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-surface-200 hover:shadow-md transition-shadow duration-200">
            <div class="px-6 py-4 border-b border-surface-200">
                <h6 class="text-lg font-semibold flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    {{ __('Update Password') }}
                </h6>
            </div>
            <div class="p-6">
                @include('profile.partials.update-password-form')
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-surface-200 hover:shadow-md transition-shadow duration-200">
            <div class="px-6 py-4 border-b border-surface-200">
                <h6 class="text-lg font-semibold flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    {{ __('Multi-Factor Authentication') }}
                </h6>
            </div>
            <div class="p-6">
                <section>
                    <p class="text-sm text-surface-600 mb-6">
                        {{ __('Add a second step to protect access to inventory controls.') }}
                    </p>
                    <form method="post" action="{{ route('mfa.settings.update') }}" class="space-y-6">
                        @csrf
                        @method('put')
                        <div class="flex items-center">
                            <input class="w-4 h-4 text-primary-600 bg-surface-100 border-surface-300 rounded focus:ring-primary-500 focus:ring-2 mr-3" type="checkbox" id="mfa_enabled" name="mfa_enabled" value="1" {{ auth()->user()->mfa_enabled ? 'checked' : '' }}>
                            <label class="block text-sm font-medium text-surface-700" for="mfa_enabled">{{ __('Enable email-based Two-Factor Authentication') }}</label>
                        </div>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            {{ __('Save') }}
                        </button>
                        @if (session('status') === 'mfa-enabled')
                            <p class="text-sm text-success-600 mt-3">{{ __('MFA enabled. You will be asked for a code at sign-in.') }}</p>
                        @elseif (session('status') === 'mfa-disabled')
                            <p class="text-sm text-surface-600 mt-3">{{ __('MFA disabled for your account.') }}</p>
                        @endif
                    </form>
                </section>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-surface-200 hover:shadow-md transition-shadow duration-200">
            <div class="px-6 py-4 border-b border-surface-200">
                <h6 class="text-lg font-semibold flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.828 4.828A4 4 0 015.5 4H9v1H5.5a3 3 0 00-2.121.879l-.707.707A1 1 0 002 7.414V16.5A1.5 1.5 0 003.5 18H12v1H3.5A2.5 2.5 0 011 16.5V7.414a2 2 0 01.586-1.414l.707-.707z" />
                    </svg>
                    {{ __('Notification Settings') }}
                </h6>
            </div>
            <div class="p-6">
                @include('profile.partials.notification-settings')
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm border border-surface-200 hover:shadow-md transition-shadow duration-200 lg:col-span-2">
            <div class="px-6 py-4 border-b border-surface-200">
                <h6 class="text-lg font-semibold flex items-center text-danger-600">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    {{ __('Delete Account') }}
                </h6>
            </div>
            <div class="p-6">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection
