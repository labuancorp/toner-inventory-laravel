<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Notifications\AccountLockoutAlert;

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
    }
}
