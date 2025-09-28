<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\Login;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Mail\Events\MessageFailed;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Notifications\AccountLockoutAlert;
use App\Models\EmailLog;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Use Bootstrap-styled pagination links across the app
        Paginator::useBootstrap();

        Event::listen(Lockout::class, function ($event): void {
            $email = (string) $event->request->input('email');
            $ip = (string) $event->request->ip();

            $admins = User::where('role', 'admin')->get();
            if ($admins->isNotEmpty()) {
                Notification::send($admins, new AccountLockoutAlert($email, $ip));
            }
        });

        // Track last login timestamp (guarded if column exists)
        Event::listen(Login::class, function ($event): void {
            if (property_exists($event, 'user') && $event->user) {
                if (Schema::hasColumn('users', 'last_login_at')) {
                    $event->user->forceFill(['last_login_at' => now()])->save();
                }
            }
        });

        // Gate for user management beyond role middleware
        Gate::define('manage-users', function (User $user): bool {
            return in_array($user->role, ['admin', 'manager']);
        });

        // Email delivery tracking
        Event::listen(MessageSent::class, function (MessageSent $event): void {
            try {
                $to = optional($event->message->getTo())[0] ?? null;
                EmailLog::create([
                    'to_email' => $to ? (method_exists($to, 'getAddress') ? $to->getAddress() : (string)$to) : null,
                    'subject' => $event->message->getSubject(),
                    'status' => 'sent',
                    'provider_message_id' => method_exists($event->message, 'getHeaders') ? (string) $event->message->getHeaders()->getHeader('Message-ID')?->getValue() : null,
                    'notification_type' => null,
                    'meta' => [],
                ]);
            } catch (\Throwable $e) {
                // Swallow tracking errors to avoid impacting mail sending
            }
        });

        Event::listen(MessageFailed::class, function (MessageFailed $event): void {
            try {
                $to = optional($event->message->getTo())[0] ?? null;
                EmailLog::create([
                    'to_email' => $to ? (method_exists($to, 'getAddress') ? $to->getAddress() : (string)$to) : null,
                    'subject' => $event->message->getSubject(),
                    'status' => 'failed',
                    'provider_message_id' => method_exists($event->message, 'getHeaders') ? (string) $event->message->getHeaders()->getHeader('Message-ID')?->getValue() : null,
                    'notification_type' => null,
                    'meta' => ['error' => $event->exception?->getMessage()],
                ]);
            } catch (\Throwable $e) {
                // Swallow tracking errors
            }
        });
    }
}
