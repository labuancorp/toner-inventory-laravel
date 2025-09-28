<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('app.profile.notification_settings') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('app.profile.notification_settings_help') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.notifications.update') }}" class="mt-6 space-y-4">
        @csrf
        @method('put')

        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="pref_order_emails_enabled" name="pref_order_emails_enabled" value="1" {{ auth()->user()->pref_order_emails_enabled ? 'checked' : '' }}>
            <label class="form-check-label" for="pref_order_emails_enabled">{{ __('app.profile.enable_order_emails') }}</label>
        </div>

        <div>
            <label for="pref_email_format" class="form-label">{{ __('app.profile.preferred_email_format') }}</label>
            <select id="pref_email_format" name="pref_email_format" class="form-select">
                <option value="html" {{ auth()->user()->pref_email_format === 'html' ? 'selected' : '' }}>{{ __('app.profile.html') }}</option>
                <option value="text" {{ auth()->user()->pref_email_format === 'text' ? 'selected' : '' }}>{{ __('app.profile.plain_text') }}</option>
            </select>
        </div>

        <div>
            <label for="pref_notification_frequency" class="form-label">{{ __('app.profile.notification_frequency') }}</label>
            <select id="pref_notification_frequency" name="pref_notification_frequency" class="form-select">
                <option value="immediate" {{ auth()->user()->pref_notification_frequency === 'immediate' ? 'selected' : '' }}>{{ __('app.profile.immediate') }}</option>
                <option value="daily" {{ auth()->user()->pref_notification_frequency === 'daily' ? 'selected' : '' }}>{{ __('app.profile.daily_digest') }}</option>
                <option value="weekly" {{ auth()->user()->pref_notification_frequency === 'weekly' ? 'selected' : '' }}>{{ __('app.profile.weekly_digest') }}</option>
            </select>
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">{{ __('app.profile.save_preferences') }}</button>
            @if (session('status') === 'notifications-updated')
                <p class="text-sm text-success mt-2">{{ __('app.profile.preferences_updated') }}</p>
            @endif
        </div>
    </form>
</section>