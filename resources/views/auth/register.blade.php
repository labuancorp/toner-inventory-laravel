<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center px-4 sm:px-8 lg:px-12 py-8">
        <div class="w-full max-w-screen-xl grid grid-cols-1 gap-6">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <div class="mb-4">
                    <h1 class="text-2xl font-semibold tracking-tight">Create your account</h1>
                    <p class="text-sm text-gray-600">Join to manage inventory and place orders seamlessly.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <div class="mt-1 relative">
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus class="block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 pr-10" />
                            <i class="ti ti-user absolute right-3 top-1/2 -translate-y-1/2 text-gray-400" aria-hidden="true"></i>
                        </div>
                        @error('name')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <div class="mt-1 relative">
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 pr-10" />
                            <i class="ti ti-mail absolute right-3 top-1/2 -translate-y-1/2 text-gray-400" aria-hidden="true"></i>
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="mt-1 relative">
                            <input id="password" type="password" name="password" required autocomplete="new-password" class="block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 pr-10" />
                            <button type="button" id="togglePassword" class="absolute right-10 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600" aria-label="Toggle password visibility">
                                <i class="ti ti-eye"></i>
                            </button>
                            <i class="ti ti-lock absolute right-3 top-1/2 -translate-y-1/2 text-gray-400" aria-hidden="true"></i>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror

                        <!-- Strength Meter -->
                        <div class="mt-3">
                            <div class="h-2 w-full bg-gray-200 rounded">
                                <div id="pwdStrengthBar" class="h-2 rounded bg-rose-500" style="width: 0%;"></div>
                            </div>
                            <ul class="mt-2 space-y-1 text-sm" id="pwdChecklist" aria-live="polite">
                                <li data-rule="len" class="flex items-center gap-2 text-gray-600"><i class="ti ti-circle-small"></i> At least 12 characters</li>
                                <li data-rule="case" class="flex items-center gap-2 text-gray-600"><i class="ti ti-circle-small"></i> Uppercase and lowercase letters</li>
                                <li data-rule="num" class="flex items-center gap-2 text-gray-600"><i class="ti ti-circle-small"></i> At least one number</li>
                                <li data-rule="sym" class="flex items-center gap-2 text-gray-600"><i class="ti ti-circle-small"></i> At least one symbol</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <div class="mt-1 relative">
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 pr-10" />
                            <button type="button" id="togglePasswordConfirm" class="absolute right-10 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600" aria-label="Toggle confirm password visibility">
                                <i class="ti ti-eye"></i>
                            </button>
                            <i class="ti ti-lock absolute right-3 top-1/2 -translate-y-1/2 text-gray-400" aria-hidden="true"></i>
                        </div>
                        @error('password_confirmation')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- CAPTCHA -->
                    <div>
                        <label for="captcha" class="block text-sm font-medium text-gray-700">CAPTCHA: What is {{ $a ?? 0 }} + {{ $b ?? 0 }}?</label>
                        <div class="mt-1 relative">
                            <input id="captcha" type="number" name="captcha" required class="block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 pr-10" />
                            <i class="ti ti-calculator absolute right-3 top-1/2 -translate-y-1/2 text-gray-400" aria-hidden="true"></i>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">This simple check helps prevent automated registrations.</p>
                        @error('captcha')
                            <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between pt-2">
                        <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900 inline-flex items-center gap-2">
                            <i class="ti ti-login" aria-hidden="true"></i>
                            <span>Already registered?</span>
                        </a>
                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <i class="ti ti-user-plus" aria-hidden="true"></i>
                            <span>Register</span>
                        </button>
                    </div>
                </form>
            </div>

            <div class="hidden md:block bg-white rounded-lg p-6 border border-gray-200">
                <div class="h-full flex flex-col">
                    <div class="flex items-center gap-2 mb-3">
                        <i class="ti ti-shield-check text-indigo-600" aria-hidden="true"></i>
                        <h2 class="text-lg font-medium">Security first</h2>
                    </div>
                    <p class="text-sm text-gray-700">We require strong passwords to protect access to inventory controls. Your data is handled with care.</p>
                    <hr class="my-4">
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-start gap-2"><i class="ti ti-circle-check text-emerald-600 mt-0.5"></i> Manage items and categories efficiently</li>
                        <li class="flex items-start gap-2"><i class="ti ti-circle-check text-emerald-600 mt-0.5"></i> Place and track orders securely</li>
                        <li class="flex items-start gap-2"><i class="ti ti-circle-check text-emerald-600 mt-0.5"></i> Optional multi‑factor authentication for extra protection</li>
                    </ul>
                    <div class="mt-auto pt-6 text-xs text-gray-500">By registering, you agree to our acceptable use policy.</div>
                </div>
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
            el.classList.toggle('text-emerald-600', ok);
            el.classList.toggle('text-gray-600', !ok);
            const icon = el.querySelector('i');
            if(icon){
                icon.className = ok ? 'ti ti-circle-check' : 'ti ti-circle-small';
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
            bar.className = 'h-2 rounded ' + (score <= 1 ? 'bg-rose-500' : score === 2 ? 'bg-amber-500' : score === 3 ? 'bg-indigo-500' : 'bg-emerald-500');
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