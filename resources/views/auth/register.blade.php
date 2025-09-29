<x-guest-layout>
    <div class="win11-min-h-screen win11-flex win11-items-center win11-justify-center win11-px-md sm:win11-px-lg lg:win11-px-xl win11-py-lg">
        <div class="win11-w-full win11-max-w-screen-xl win11-grid win11-grid-cols-1 win11-gap-lg">
            <div class="win11-card win11-card-acrylic win11-p-lg">
                <div class="win11-mb-md">
                    <h1 class="win11-text-2xl win11-font-semibold win11-tracking-tight">Create your account</h1>
                    <p class="win11-text-sm win11-text-secondary">Join to manage inventory and place orders seamlessly.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="win11-space-y-md">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="win11-block win11-text-sm win11-font-medium win11-text-primary">Name</label>
                        <div class="win11-mt-1 win11-relative">
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus class="win11-block win11-w-full win11-input win11-pr-10" />
                            <svg class="win11-absolute win11-right-3 win11-top-1/2 win11-transform win11--translate-y-1/2 win11-text-secondary win11-w-4 win11-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        @error('name')
                            <p class="win11-mt-2 win11-text-sm win11-text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="win11-block win11-text-sm win11-font-medium win11-text-primary">Email</label>
                        <div class="win11-mt-1 win11-relative">
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="win11-block win11-w-full win11-input win11-pr-10" />
                            <svg class="win11-absolute win11-right-3 win11-top-1/2 win11-transform win11--translate-y-1/2 win11-text-secondary win11-w-4 win11-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        @error('email')
                            <p class="win11-mt-2 win11-text-sm win11-text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="win11-block win11-text-sm win11-font-medium win11-text-primary">Password</label>
                        <div class="win11-mt-1 win11-relative">
                            <input id="password" type="password" name="password" required autocomplete="new-password" class="win11-block win11-w-full win11-input win11-pr-20" />
                            <button type="button" id="togglePassword" class="win11-absolute win11-right-10 win11-top-1/2 win11-transform win11--translate-y-1/2 win11-text-secondary hover:win11-text-primary" aria-label="Toggle password visibility">
                                <svg class="win11-w-4 win11-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                            <svg class="win11-absolute win11-right-3 win11-top-1/2 win11-transform win11--translate-y-1/2 win11-text-secondary win11-w-4 win11-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        @error('password')
                            <p class="win11-mt-2 win11-text-sm win11-text-danger">{{ $message }}</p>
                        @enderror

                        <!-- Strength Meter -->
                        <div class="win11-mt-3">
                            <div class="win11-progress">
                                <div id="pwdStrengthBar" class="win11-progress-bar win11-bg-danger" style="width: 0%;"></div>
                            </div>
                            <ul class="win11-mt-2 win11-space-y-1 win11-text-sm" id="pwdChecklist" aria-live="polite">
                                <li data-rule="len" class="win11-flex win11-items-center win11-gap-2 win11-text-secondary">
                                    <svg class="win11-w-3 win11-h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <circle cx="10" cy="10" r="2" />
                                    </svg>
                                    At least 12 characters
                                </li>
                                <li data-rule="case" class="win11-flex win11-items-center win11-gap-2 win11-text-secondary">
                                    <svg class="win11-w-3 win11-h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <circle cx="10" cy="10" r="2" />
                                    </svg>
                                    Uppercase and lowercase letters
                                </li>
                                <li data-rule="num" class="win11-flex win11-items-center win11-gap-2 win11-text-secondary">
                                    <svg class="win11-w-3 win11-h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <circle cx="10" cy="10" r="2" />
                                    </svg>
                                    At least one number
                                </li>
                                <li data-rule="sym" class="win11-flex win11-items-center win11-gap-2 win11-text-secondary">
                                    <svg class="win11-w-3 win11-h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <circle cx="10" cy="10" r="2" />
                                    </svg>
                                    At least one symbol
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="win11-block win11-text-sm win11-font-medium win11-text-primary">Confirm Password</label>
                        <div class="win11-mt-1 win11-relative">
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="win11-block win11-w-full win11-input win11-pr-20" />
                            <button type="button" id="togglePasswordConfirm" class="win11-absolute win11-right-10 win11-top-1/2 win11-transform win11--translate-y-1/2 win11-text-secondary hover:win11-text-primary" aria-label="Toggle confirm password visibility">
                                <svg class="win11-w-4 win11-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                            <svg class="win11-absolute win11-right-3 win11-top-1/2 win11-transform win11--translate-y-1/2 win11-text-secondary win11-w-4 win11-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        @error('password_confirmation')
                            <p class="win11-mt-2 win11-text-sm win11-text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- CAPTCHA -->
                    <div>
                        <label for="captcha" class="win11-block win11-text-sm win11-font-medium win11-text-primary">CAPTCHA: What is {{ $a ?? 0 }} + {{ $b ?? 0 }}?</label>
                        <div class="win11-mt-1 win11-relative">
                            <input id="captcha" type="number" name="captcha" required class="win11-block win11-w-full win11-input win11-pr-10" />
                            <svg class="win11-absolute win11-right-3 win11-top-1/2 win11-transform win11--translate-y-1/2 win11-text-secondary win11-w-4 win11-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6l2 9H7l2-9zM9 7V5a2 2 0 012-2h2a2 2 0 012 2v2M7 13h10" />
                            </svg>
                        </div>
                        <p class="win11-mt-1 win11-text-xs win11-text-secondary">This simple check helps prevent automated registrations.</p>
                        @error('captcha')
                            <p class="win11-mt-2 win11-text-sm win11-text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Actions -->
                    <div class="win11-flex win11-items-center win11-justify-between win11-pt-2">
                        <a href="{{ route('login') }}" class="win11-link win11-text-sm win11-inline-flex win11-items-center win11-gap-2">
                            <svg class="win11-w-4 win11-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            <span>Already registered?</span>
                        </a>
                        <button type="submit" class="win11-btn win11-btn-primary win11-inline-flex win11-items-center win11-gap-2">
                            <svg class="win11-w-4 win11-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            <span>Register</span>
                        </button>
                    </div>
                </form>
            </div>

            <div class="hidden md:block win11-card win11-acrylic win11-p-6">
                <div class="win11-h-full win11-flex win11-flex-col">
                    <div class="win11-flex win11-items-center win11-gap-2 win11-mb-3">
                        <svg class="win11-w-6 win11-h-6 win11-text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <h2 class="win11-text-lg win11-font-medium win11-text-primary">Security first</h2>
                    </div>
                    <p class="win11-text-sm win11-text-secondary">Your account security is our priority. We implement industry-standard practices to protect your data.</p>
                    <hr class="win11-my-4 win11-border-divider">
                    <ul class="win11-space-y-2 win11-text-sm win11-text-secondary">
                        <li class="win11-flex win11-items-start win11-gap-2">
                            <svg class="win11-w-4 win11-h-4 win11-text-success win11-mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Passwords are securely hashed using bcrypt
                        </li>
                        <li class="win11-flex win11-items-start win11-gap-2">
                            <svg class="win11-w-4 win11-h-4 win11-text-success win11-mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Session management with automatic timeout
                        </li>
                        <li class="win11-flex win11-items-start win11-gap-2">
                            <svg class="win11-w-4 win11-h-4 win11-text-success win11-mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Comprehensive audit logging for inventory changes
                        </li>
                        <li class="win11-flex win11-items-start win11-gap-2">
                            <svg class="win11-w-4 win11-h-4 win11-text-success win11-mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Role-based access control for different user types
                        </li>
                    </ul>
                    <div class="win11-mt-auto win11-pt-6 win11-text-xs win11-text-tertiary">By registering, you agree to our acceptable use policy.</div>
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
            el.classList.toggle('win11-text-success', ok);
            el.classList.toggle('win11-text-secondary', !ok);
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
            bar.className = 'win11-progress-bar ' + (score <= 1 ? 'win11-bg-danger' : score === 2 ? 'win11-bg-warning' : score === 3 ? 'win11-bg-info' : 'win11-bg-success');
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