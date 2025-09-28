<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="space-y-6">
        <div class="text-center">
            <h1 class="text-2xl font-semibold tracking-tight">Welcome back</h1>
            <p class="text-sm text-gray-600">Sign in to manage your toner inventory</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-4" aria-describedby="loginHelp">
            @csrf

            <div id="loginHelp" class="sr-only">Enter your email and password to sign in.</div>

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password with visibility toggle -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <div class="mt-1 relative">
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="block w-full rounded-md border border-gray-300 px-3 py-2 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" />
                    <button type="button" id="togglePassword" aria-label="Toggle password visibility" aria-controls="password" aria-pressed="false"
                        class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                        <!-- Eye icon -->
                        <svg id="iconEye" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                        <!-- Eye-off icon -->
                        <svg id="iconEyeOff" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M17.94 17.94A10.94 10.94 0 0112 20c-7 0-11-8-11-8a21.58 21.58 0 015.06-6.94M9.88 4.12A10.94 10.94 0 0112 4c7 0 11 8 11 8a21.58 21.58 0 01-4.62 6.2" />
                            <path d="M1 1l22 22" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <label for="remember_me" class="inline-flex items-center gap-2">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="text-sm text-gray-600">Remember me</span>
                </label>
                @if (Route::has('password.request'))
                <a class="text-sm text-indigo-600 hover:text-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded" href="{{ route('password.request') }}">
                    Forgot your password?
                </a>
                @endif
            </div>

            <!-- Submit -->
            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition transform hover:-translate-y-px">
                <span>Log in</span>
            </button>

            <!-- Divider -->
            <div class="flex items-center gap-3">
                <div class="h-px flex-1 bg-gray-200"></div>
                <span class="text-xs text-gray-500">or</span>
                <div class="h-px flex-1 bg-gray-200"></div>
            </div>

            <!-- Optional Social Login (placeholders) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" aria-label="Social login options">
                <button type="button" aria-disabled="true" title="Social login coming soon"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-md border border-gray-300 bg-white text-gray-800 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                    <!-- Google icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-4 w-4" aria-hidden="true"><path fill="#EA4335" d="M12 10.2v3.6h5.1c-.2 1.1-1.2 3.2-5.1 3.2-3 0-5.4-2.5-5.4-5.6s2.4-5.6 5.4-5.6c1.7 0 2.9.7 3.6 1.3l2.4-2.3C16.8 3.4 14.6 2.4 12 2.4 6.9 2.4 2.7 6.6 2.7 11.7s4.2 9.3 9.3 9.3c5.4 0 9-3.8 9-9.2 0-.6-.1-1-.2-1.5H12z"/></svg>
                    <span>Continue with Google</span>
                </button>
                <button type="button" aria-disabled="true" title="Social login coming soon"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-md border border-gray-300 bg-white text-gray-800 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                    <!-- Microsoft icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-4 w-4" aria-hidden="true"><path fill="#F25022" d="M11 11H3V3h8z"/><path fill="#7FBA00" d="M21 11h-8V3h8z"/><path fill="#00A4EF" d="M11 21H3v-8h8z"/><path fill="#FFB900" d="M21 21h-8v-8h8z"/></svg>
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
