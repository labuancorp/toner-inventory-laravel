<section>
    <header class="win11-mb-md">
        <p class="win11-text-sm win11-text-secondary">
            {{ __('app.profile.notification_settings_help') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.notifications.update') }}" class="win11-space-y-md">
        @csrf
        @method('put')

        <div class="win11-flex win11-items-center">
            <input class="win11-checkbox win11-mr-sm" type="checkbox" id="pref_order_emails_enabled" name="pref_order_emails_enabled" value="1" {{ auth()->user()->pref_order_emails_enabled ? 'checked' : '' }}>
            <label class="win11-label" for="pref_order_emails_enabled">{{ __('app.profile.enable_order_emails') }}</label>
        </div>

        <div>
            <label for="pref_email_format" class="win11-label">{{ __('app.profile.preferred_email_format') }}</label>
            <select id="pref_email_format" name="pref_email_format" class="win11-select win11-w-full">
                <option value="html" {{ auth()->user()->pref_email_format === 'html' ? 'selected' : '' }}>{{ __('app.profile.html') }}</option>
                <option value="text" {{ auth()->user()->pref_email_format === 'text' ? 'selected' : '' }}>{{ __('app.profile.plain_text') }}</option>
            </select>
        </div>

        <div>
            <label for="pref_notification_frequency" class="win11-label">{{ __('app.profile.notification_frequency') }}</label>
            <select id="pref_notification_frequency" name="pref_notification_frequency" class="win11-select win11-w-full">
                <option value="immediate" {{ auth()->user()->pref_notification_frequency === 'immediate' ? 'selected' : '' }}>{{ __('app.profile.immediate') }}</option>
                <option value="daily" {{ auth()->user()->pref_notification_frequency === 'daily' ? 'selected' : '' }}>{{ __('app.profile.daily_digest') }}</option>
                <option value="weekly" {{ auth()->user()->pref_notification_frequency === 'weekly' ? 'selected' : '' }}>{{ __('app.profile.weekly_digest') }}</option>
            </select>
        </div>

        <div class="win11-flex win11-items-center win11-gap-md">
            <button type="submit" class="win11-btn win11-btn-primary">
                <svg class="win11-w-4 win11-h-4 win11-mr-xs" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ __('app.profile.save_preferences') }}
            </button>
            @if (session('status') === 'notifications-updated')
                <p class="win11-text-sm win11-text-success">{{ __('app.profile.preferences_updated') }}</p>
            @endif
        </div>
    </form>
</section>