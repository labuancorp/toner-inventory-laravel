<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="win11-mb-md" :status="session('status')" />

    <div class="win11-space-y-lg">
        <div class="win11-text-center">
            <h1 class="win11-text-2xl win11-font-semibold win11-tracking-tight">Welcome back</h1>
            <p class="win11-text-sm win11-text-secondary">Sign in to manage your toner inventory</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="win11-space-y-md" aria-describedby="loginHelp">
            @csrf

            <div id="loginHelp" class="win11-sr-only">Enter your email and password to sign in.</div>

            <!-- Email Address -->
            <div>
                <label for="email" class="win11-block win11-text-sm win11-font-medium win11-text-primary">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    class="win11-mt-1 win11-block win11-w-full win11-input win11-text-sm" />
                <x-input-error :messages="$errors->get('email')" class="win11-mt-2" />
            </div>

            <!-- Password with visibility toggle -->
            <div>
                <label for="password" class="win11-block win11-text-sm win11-font-medium win11-text-primary">Password</label>
                <div class="win11-mt-1 win11-relative">
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="win11-block win11-w-full win11-input win11-text-sm win11-pr-10" />
                    <button type="button" id="togglePassword" aria-label="Toggle password visibility" aria-controls="password" aria-pressed="false"
                        class="win11-absolute win11-inset-y-0 win11-right-0 win11-px-3 win11-flex win11-items-center win11-text-secondary hover:win11-text-primary win11-focus-outline-none win11-focus-ring-2 win11-focus-ring-accent win11-transition">
                        <!-- Eye icon -->
                        <svg id="iconEye" xmlns="http://www.w3.org/2000/svg" class="win11-h-5 win11-w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                        <!-- Eye-off icon -->
                        <svg id="iconEyeOff" xmlns="http://www.w3.org/2000/svg" class="win11-h-5 win11-w-5 win11-hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M17.94 17.94A10.94 10.94 0 0112 20c-7 0-11-8-11-8a21.58 21.58 0 015.06-6.94M9.88 4.12A10.94 10.94 0 0112 4c7 0 11 8 11 8a21.58 21.58 0 01-4.62 6.2" />
                            <path d="M1 1l22 22" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="win11-mt-2" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="win11-flex win11-flex-col sm:win11-flex-row sm:win11-items-center sm:win11-justify-between win11-gap-2">
                <label for="remember_me" class="win11-inline-flex win11-items-center win11-gap-2">
                    <input id="remember_me" type="checkbox" class="win11-checkbox" name="remember">
                    <span class="win11-text-sm win11-text-secondary">Remember me</span>
                </label>
                @if (Route::has('password.request'))
                <a class="win11-link win11-text-sm" href="{{ route('password.request') }}">
                    Forgot your password?
                </a>
                @endif
            </div>

            <!-- Submit -->
            <button type="submit" class="win11-w-full win11-btn win11-btn-primary win11-inline-flex win11-items-center win11-justify-center win11-gap-2">
                <span>Log in</span>
            </button>

            <!-- Divider -->
            <div class="win11-flex win11-items-center win11-gap-3">
                <div class="win11-h-px win11-flex-1 win11-bg-border"></div>
                <span class="win11-text-xs win11-text-secondary">or</span>
                <div class="win11-h-px win11-flex-1 win11-bg-border"></div>
            </div>

            <!-- Optional Social Login (placeholders) -->
            <div class="win11-grid win11-grid-cols-1 sm:win11-grid-cols-2 win11-gap-3" aria-label="Social login options">
                <button type="button" aria-disabled="true" title="Social login coming soon"
                    class="win11-btn win11-btn-outline win11-inline-flex win11-items-center win11-justify-center win11-gap-2">
                    <!-- Google icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="win11-h-4 win11-w-4" aria-hidden="true"><path fill="#EA4335" d="M12 10.2v3.6h5.1c-.2 1.1-1.2 3.2-5.1 3.2-3 0-5.4-2.5-5.4-5.6s2.4-5.6 5.4-5.6c1.7 0 2.9.7 3.6 1.3l2.4-2.3C16.8 3.4 14.6 2.4 12 2.4 6.9 2.4 2.7 6.6 2.7 11.7s4.2 9.3 9.3 9.3c5.4 0 9-3.8 9-9.2 0-.6-.1-1-.2-1.5H12z"/></svg>
                    <span>Continue with Google</span>
                </button>
                <button type="button" aria-disabled="true" title="Social login coming soon"
                    class="win11-btn win11-btn-outline win11-inline-flex win11-items-center win11-justify-center win11-gap-2">
                    <!-- Microsoft icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="win11-h-4 win11-w-4" aria-hidden="true"><path fill="#F25022" d="M11 11H3V3h8z"/><path fill="#7FBA00" d="M21 11h-8V3h8z"/><path fill="#00A4EF" d="M11 21H3v-8h8z"/><path fill="#FFB900" d="M21 21h-8v-8h8z"/></svg>
                    <span>Continue with Microsoft</span>
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
    (function(){
        const input = document.getElementById('password');
        const btn = document.getElementById('togglePassword');
        const eye = document.getElementById('iconEye');
        const off = document.getElementById('iconEyeOff');
        if(!input || !btn || !eye || !off) return;
        btn.addEventListener('click', function(){
            const nowText = input.type === 'text';
            input.type = nowText ? 'password' : 'text';
            this.setAttribute('aria-pressed', String(!nowText));
            const isText = input.type === 'text';
            eye.classList.toggle('hidden', isText);
            off.classList.toggle('hidden', !isText);
        });
    })();
    </script>
    @endpush
</x-guest-layout>
