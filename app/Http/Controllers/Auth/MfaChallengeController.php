<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use App\Notifications\TwoFactorCode;

class MfaChallengeController extends Controller
{
    public function create(Request $request): View|RedirectResponse
    {
        $pendingId = $request->session()->get('mfa_user_id');
        if (! $pendingId) {
            return redirect()->route('login');
        }
        return view('auth.mfa-challenge');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'digits:6'],
        ]);

        $pendingId = $request->session()->get('mfa_user_id');
        if (! $pendingId) {
            return redirect()->route('login');
        }

        $cached = Cache::get('mfa:code:'.$pendingId);
        if (! $cached || $cached !== $request->code) {
            return back()->withErrors(['code' => __('Invalid or expired code.')]);
        }

        Cache::forget('mfa:code:'.$pendingId);
        $request->session()->forget('mfa_user_id');

        Auth::loginUsingId($pendingId);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public static function sendCode(User $user): void
    {
        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        Cache::put('mfa:code:'.$user->id, $code, now()->addMinutes(10));
        Notification::send($user, new TwoFactorCode($code));
    }
}