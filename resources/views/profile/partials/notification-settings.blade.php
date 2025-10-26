<section>
    <header class="mb-6">
        <p class="text-sm text-surface-600">
            {{ __('app.profile.notification_settings_help') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.notifications.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div class="flex items-center">
            <input class="w-4 h-4 text-primary-600 bg-surface-100 border-surface-300 rounded focus:ring-primary-500 focus:ring-2 mr-3" type="checkbox" id="pref_order_emails_enabled" name="pref_order_emails_enabled" value="1" {{ auth()->user()->pref_order_emails_enabled ? 'checked' : '' }}>
            <label class="block text-sm font-medium text-surface-700" for="pref_order_emails_enabled">{{ __('app.profile.enable_order_emails') }}</label>
        </div>

        <div>
            <label for="pref_email_format" class="block text-sm font-medium text-surface-700 mb-2">{{ __('app.profile.preferred_email_format') }}</label>
            <select id="pref_email_format" name="pref_email_format" class="w-full px-3 py-2 border border-surface-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200">
                <option value="html" {{ auth()->user()->pref_email_format === 'html' ? 'selected' : '' }}>{{ __('app.profile.html') }}</option>
                <option value="text" {{ auth()->user()->pref_email_format === 'text' ? 'selected' : '' }}>{{ __('app.profile.plain_text') }}</option>
            </select>
        </div>

        <div>
            <label for="pref_notification_frequency" class="block text-sm font-medium text-surface-700 mb-2">{{ __('app.profile.notification_frequency') }}</label>
            <select id="pref_notification_frequency" name="pref_notification_frequency" class="w-full px-3 py-2 border border-surface-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200">
                <option value="immediate" {{ auth()->user()->pref_notification_frequency === 'immediate' ? 'selected' : '' }}>{{ __('app.profile.immediate') }}</option>
                <option value="daily" {{ auth()->user()->pref_notification_frequency === 'daily' ? 'selected' : '' }}>{{ __('app.profile.daily_digest') }}</option>
                <option value="weekly" {{ auth()->user()->pref_notification_frequency === 'weekly' ? 'selected' : '' }}>{{ __('app.profile.weekly_digest') }}</option>
            </select>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ __('app.profile.save_preferences') }}
            </button>
            @if (session('status') === 'notifications-updated')
                <p class="text-sm text-success-600">{{ __('app.profile.preferences_updated') }}</p>
            @endif
        </div>
    </form>
</section>