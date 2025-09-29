<section class="win11-space-y-md">
    <header class="win11-mb-md">
        <p class="win11-text-sm win11-text-secondary">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="win11-btn win11-btn-danger"
    >
        <svg class="win11-w-4 win11-h-4 win11-mr-xs" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
        </svg>
        {{ __('Delete Account') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="win11-p-lg">
            @csrf
            @method('delete')

            <h2 class="win11-text-lg win11-font-semibold win11-text-danger win11-mb-md">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="win11-text-sm win11-text-secondary win11-mb-lg">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="win11-mb-lg">
                <label for="password" class="win11-sr-only">{{ __('Password') }}</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="win11-input win11-w-3/4"
                    placeholder="{{ __('Password') }}"
                />
                @error('password', 'userDeletion')
                    <p class="win11-text-sm win11-text-danger win11-mt-xs">{{ $message }}</p>
                @enderror
            </div>

            <div class="win11-flex win11-justify-end win11-gap-md">
                <button type="button" x-on:click="$dispatch('close')" class="win11-btn win11-btn-secondary">
                    {{ __('Cancel') }}
                </button>

                <button type="submit" class="win11-btn win11-btn-danger">
                    <svg class="win11-w-4 win11-h-4 win11-mr-xs" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
