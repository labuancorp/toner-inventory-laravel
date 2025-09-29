<section>
    <header class="win11-mb-md">
        <p class="win11-text-sm win11-text-secondary">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="win11-space-y-md">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="win11-label">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" class="win11-input win11-w-full" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            @error('name')
                <p class="win11-text-sm win11-text-danger win11-mt-xs">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="win11-label">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="win11-input win11-w-full" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @error('email')
                <p class="win11-text-sm win11-text-danger win11-mt-xs">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="win11-mt-sm">
                    <p class="win11-text-sm win11-text-warning">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="win11-text-primary hover:win11-text-primary-dark win11-underline win11-ml-xs">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="win11-text-sm win11-text-success win11-mt-xs">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="win11-flex win11-items-center win11-gap-md">
            <button type="submit" class="win11-btn win11-btn-primary">
                <svg class="win11-w-4 win11-h-4 win11-mr-xs" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ __('Save') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="win11-text-sm win11-text-success"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
