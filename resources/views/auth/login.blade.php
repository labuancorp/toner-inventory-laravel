<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <div class="space-y-8">
        <!-- Header with Logo and Branding -->
        <div class="text-center space-y-4">
            <!-- Logo/Icon -->
            <div class="mx-auto flex justify-center mb-6">
                <img src="{{ asset('images/pl-logo.svg') }}" alt="Perbadanan Labuan Logo" class="h-16 w-auto">
            </div>
            
            <!-- Welcome Text -->
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-gray-100">Welcome Back</h1>
                <p class="text-base text-gray-600 dark:text-gray-400 mt-2">Sign in to your Toner Inventory System</p>
            </div>
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-6" aria-describedby="loginHelp">
            @csrf

            <div id="loginHelp" class="sr-only">Enter your email and password to sign in.</div>

            <!-- Email Address -->
            <div class="space-y-2">
                <label for="email" class="block text-sm font-semibold text-gray-900 dark:text-gray-100">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm"
                        placeholder="Enter your email address" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password with visibility toggle -->
            <div class="space-y-2">
                <label for="password" class="block text-sm font-semibold text-gray-900 dark:text-gray-100">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="block w-full pl-10 pr-12 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm"
                        placeholder="Enter your password" />
                    <button type="button" id="togglePassword" aria-label="Toggle password visibility" aria-controls="password" aria-pressed="false"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
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
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <label for="remember_me" class="inline-flex items-center gap-3 cursor-pointer">
                    <input id="remember_me" type="checkbox" class="w-4 h-4 rounded border-gray-300 dark:border-gray-600 text-blue-600 focus:ring-blue-500 focus:ring-2" name="remember">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Remember me for 30 days</span>
                </label>
                @if (Route::has('password.request'))
                <a class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium text-sm transition-colors inline-flex items-center gap-1" href="{{ route('password.request') }}">
                    <span>Forgot password?</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transform transition-all duration-200 hover:scale-[1.02] active:scale-[0.98] inline-flex items-center justify-center gap-2 shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                <span>Sign In to Your Account</span>
            </button>

        </form>

        <!-- Additional Information -->
        <div class="text-center space-y-4">
            <div class="flex items-center gap-3">
                <div class="h-px flex-1 bg-gray-200 dark:bg-gray-700"></div>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Secure Login</span>
                <div class="h-px flex-1 bg-gray-200 dark:bg-gray-700"></div>
            </div>
            
            <!-- Security Features -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-center">
                <div class="flex flex-col items-center gap-2">
                    <div class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <span class="text-xs text-gray-600 dark:text-gray-400">SSL Encrypted</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <span class="text-xs text-gray-600 dark:text-gray-400">Secure Access</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span class="text-xs text-gray-600 dark:text-gray-400">Fast & Reliable</span>
                </div>
            </div>
        </div>
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
