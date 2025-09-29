<x-guest-layout>
    <div class="win11-space-y-lg">
        <div class="win11-text-center">
            <h1 class="win11-text-2xl win11-font-semibold win11-tracking-tight">Confirm your password</h1>
            <p class="win11-text-sm win11-text-secondary win11-mt-2">This is a secure area of the application. Please confirm your password before continuing.</p>
        </div>

        <form method="POST" action="{{ route('password.confirm') }}" class="win11-space-y-md">
            @csrf

            <!-- Password -->
            <div>
                <label for="password" class="win11-block win11-text-sm win11-font-medium win11-text-primary">Password</label>
                <div class="win11-mt-1 win11-relative">
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="win11-block win11-w-full win11-input win11-pr-10" />
                    <svg class="win11-absolute win11-right-3 win11-top-1/2 win11-transform win11--translate-y-1/2 win11-text-secondary win11-w-4 win11-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <x-input-error :messages="$errors->get('password')" class="win11-mt-2" />
            </div>

            <div class="win11-flex win11-items-center win11-justify-between win11-mt-6">
                <a href="{{ route('dashboard') }}" class="win11-link win11-text-sm win11-inline-flex win11-items-center win11-gap-2">
                    <svg class="win11-w-4 win11-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Cancel</span>
                </a>
                <button type="submit" class="win11-btn win11-btn-primary win11-inline-flex win11-items-center win11-gap-2">
                    <svg class="win11-w-4 win11-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Confirm</span>
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
