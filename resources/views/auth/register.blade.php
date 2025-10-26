<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8 py-8">
        <div class="w-full max-w-md space-y-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg p-8">
                <div class="mb-6">
                    <h1 class="text-2xl font-semibold tracking-tight text-gray-900 dark:text-white">Create your account</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Join to manage inventory and place orders seamlessly.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                        <div class="mt-1 relative">
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white pr-10" />
                            <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                        <div class="mt-1 relative">
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white pr-10" />
                            <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                        <div class="mt-1 relative">
                            <input id="password" type="password" name="password" required autocomplete="new-password" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white pr-20" />
                            <button type="button" id="togglePassword" class="absolute right-10 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" aria-label="Toggle password visibility">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                            <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror

                        <!-- Strength Meter -->
                        <div class="mt-3">
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div id="pwdStrengthBar" class="h-2 rounded-full bg-red-500 transition-all duration-300" style="width: 0%;"></div>
                            </div>
                            <ul class="mt-2 space-y-1 text-sm" id="pwdChecklist" aria-live="polite">
                                <li data-rule="len" class="flex items-center gap-2 text-gray-500 dark:text-gray-400">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <circle cx="10" cy="10" r="2" />
                                    </svg>
                                    At least 12 characters
                                </li>
                                <li data-rule="case" class="flex items-center gap-2 text-gray-500 dark:text-gray-400">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <circle cx="10" cy="10" r="2" />
                                    </svg>
                                    Uppercase and lowercase letters
                                </li>
                                <li data-rule="num" class="flex items-center gap-2 text-gray-500 dark:text-gray-400">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <circle cx="10" cy="10" r="2" />
                                    </svg>
                                    At least one number
                                </li>
                                <li data-rule="sym" class="flex items-center gap-2 text-gray-500 dark:text-gray-400">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <circle cx="10" cy="10" r="2" />
                                    </svg>
                                    At least one symbol
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm Password</label>
                        <div class="mt-1 relative">
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white pr-20" />
                            <button type="button" id="togglePasswordConfirm" class="absolute right-10 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300" aria-label="Toggle confirm password visibility">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                            <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        @error('password_confirmation')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- CAPTCHA -->
                    <div>
                        <label for="captcha" class="block text-sm font-medium text-gray-700 dark:text-gray-300">CAPTCHA: What is {{ $a ?? 0 }} + {{ $b ?? 0 }}?</label>
                        <div class="mt-1 relative">
                            <input id="captcha" type="number" name="captcha" required class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white pr-10" />
                            <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6l2 9H7l2-9zM9 7V5a2 2 0 012-2h2a2 2 0 012 2v2M7 13h10" />
                            </svg>
                        </div>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">This simple check helps prevent automated registrations.</p>
                        @error('captcha')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between pt-2">
                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300 text-sm inline-flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            <span>Already registered?</span>
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md inline-flex items-center gap-2 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            <span>Register</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Security Information -->
            <div class="mt-8 bg-white dark:bg-gray-800 shadow-xl rounded-lg p-8">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">Security first</h2>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Your account security is our priority. We implement industry-standard practices to protect your data.</p>
                <hr class="my-4 border-gray-200 dark:border-gray-700">
                <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Passwords are securely hashed using bcrypt
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Session management with automatic timeout
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Comprehensive audit logging for inventory changes
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Role-based access control for different user types
                    </li>
                </ul>
                <div class="mt-6 pt-6 text-xs text-gray-500 dark:text-gray-400">By registering, you agree to our acceptable use policy.</div>
            </div>
        </div>
    </div>

    <script>
    (function(){
        const pwd = document.getElementById('password');
        const pwd2 = document.getElementById('password_confirmation');
        const toggle = document.getElementById('togglePassword');
        const toggle2 = document.getElementById('togglePasswordConfirm');
        const bar = document.getElementById('pwdStrengthBar');
        const list = document.getElementById('pwdChecklist');

        function setRule(rule, ok){
            const el = list.querySelector('[data-rule="'+rule+'"]');
            if(!el) return;
            el.classList.toggle('text-green-500', ok);
            el.classList.toggle('text-gray-500', !ok);
            el.classList.toggle('dark:text-green-400', ok);
            el.classList.toggle('dark:text-gray-400', !ok);
            const icon = el.querySelector('svg');
            if(icon){
                if(ok) {
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />';
                } else {
                    icon.innerHTML = '<circle cx="10" cy="10" r="2" />';
                }
            }
        }

        function evaluate(val){
            const hasLen = (val || '').length >= 12;
            const hasUpper = /[A-Z]/.test(val);
            const hasLower = /[a-z]/.test(val);
            const hasCase = hasUpper && hasLower;
            const hasNum = /\d/.test(val);
            const hasSym = /[^A-Za-z0-9]/.test(val);
            const score = [hasLen, hasCase, hasNum, hasSym].filter(Boolean).length;
            const pct = [0,25,50,75,100][score];
            bar.style.width = pct + '%';
            bar.className = 'h-2 rounded-full transition-all duration-300 ' + (score <= 1 ? 'bg-red-500' : score === 2 ? 'bg-yellow-500' : score === 3 ? 'bg-blue-500' : 'bg-green-500');
            setRule('len', hasLen);
            setRule('case', hasCase);
            setRule('num', hasNum);
            setRule('sym', hasSym);
        }

        if(pwd){
            evaluate(pwd.value);
            pwd.addEventListener('input', function(){ evaluate(pwd.value); });
        }

        function toggleVisibility(input){
            if(!input) return;
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        if(toggle){ toggle.addEventListener('click', function(){ toggleVisibility(pwd); }); }
        if(toggle2){ toggle2.addEventListener('click', function(){ toggleVisibility(pwd2); }); }
    })();
    </script>
</x-guest-layout>