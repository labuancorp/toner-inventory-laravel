<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('For security, please enter the 6-digit code we emailed to you.') }}
    </div>

    <form method="POST" action="{{ route('mfa.challenge.store') }}">
        @csrf

        <!-- Code -->
        <div>
            <x-input-label for="code" :value="__('Authentication Code')" />
            <x-text-input id="code" class="block mt-1 w-full" type="text" name="code" inputmode="numeric" pattern="[0-9]*" required autofocus />
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Verify') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>