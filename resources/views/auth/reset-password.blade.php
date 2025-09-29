<x-guest-layout>
    <div class="win11-space-y-lg">
        <div class="win11-text-center">
            <h1 class="win11-text-2xl win11-font-semibold win11-tracking-tight">Reset your password</h1>
            <p class="win11-text-sm win11-text-secondary win11-mt-2">Enter your new password below to complete the reset process.</p>
        </div>

        <form method="POST" action="{{ route('password.store') }}" class="win11-space-y-md">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div>
                <label for="email" class="win11-block win11-text-sm win11-font-medium win11-text-primary">Email</label>
                <div class="win11-mt-1 win11-relative">
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                        class="win11-block win11-w-full win11-input win11-pr-10" />
                    <svg class="win11-absolute win11-right-3 win11-top-1/2 win11-transform win11--translate-y-1/2 win11-text-secondary win11-w-4 win11-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <x-input-error :messages="$errors->get('email')" class="win11-mt-2" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="win11-block win11-text-sm win11-font-medium win11-text-primary">New Password</label>
                <div class="win11-mt-1 win11-relative">
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="win11-block win11-w-full win11-input win11-pr-10" />
                    <svg class="win11-absolute win11-right-3 win11-top-1/2 win11-transform win11--translate-y-1/2 win11-text-secondary win11-w-4 win11-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <x-input-error :messages="$errors->get('password')" class="win11-mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="win11-block win11-text-sm win11-font-medium win11-text-primary">Confirm Password</label>
                <div class="win11-mt-1 win11-relative">
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="win11-block win11-w-full win11-input win11-pr-10" />
                    <svg class="win11-absolute win11-right-3 win11-top-1/2 win11-transform win11--translate-y-1/2 win11-text-secondary win11-w-4 win11-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="win11-mt-2" />
            </div>

            <div class="win11-flex win11-items-center win11-justify-between win11-mt-6">
                <a href="{{ route('login') }}" class="win11-link win11-text-sm win11-inline-flex win11-items-center win11-gap-2">
                    <svg class="win11-w-4 win11-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Back to login</span>
                </a>
                <button type="submit" class="win11-btn win11-btn-primary win11-inline-flex win11-items-center win11-gap-2">
                    <svg class="win11-w-4 win11-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    <span>Reset Password</span>
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
