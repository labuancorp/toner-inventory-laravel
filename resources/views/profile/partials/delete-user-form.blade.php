<section class="space-y-6">
    <header class="mb-6">
        <p class="text-sm text-surface-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="inline-flex items-center px-4 py-2 bg-danger-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-danger-700 focus:bg-danger-700 active:bg-danger-900 focus:outline-none focus:ring-2 focus:ring-danger-500 focus:ring-offset-2 transition ease-in-out duration-150"
    >
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
        </svg>
        {{ __('Delete Account') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-semibold text-danger-600 mb-6">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="text-sm text-surface-600 mb-8">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mb-8">
                <label for="password" class="sr-only">{{ __('Password') }}</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="w-3/4 px-3 py-2 border border-surface-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-danger-500 focus:border-danger-500 transition-colors duration-200"
                    placeholder="{{ __('Password') }}"
                />
                @error('password', 'userDeletion')
                    <p class="text-sm text-danger-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-4">
                <button type="button" x-on:click="$dispatch('close')" class="inline-flex items-center px-4 py-2 bg-surface-200 border border-surface-300 rounded-lg font-semibold text-xs text-surface-700 uppercase tracking-widest hover:bg-surface-300 focus:bg-surface-300 active:bg-surface-400 focus:outline-none focus:ring-2 focus:ring-surface-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Cancel') }}
                </button>

                <button type="submit" class="inline-flex items-center px-4 py-2 bg-danger-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-danger-700 focus:bg-danger-700 active:bg-danger-900 focus:outline-none focus:ring-2 focus:ring-danger-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
