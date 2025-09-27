<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\PasswordHistory;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::min(12)->mixedCase()->numbers()->symbols()->uncompromised()],
        ]);

        // Prevent reuse of recent passwords (last 5)
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            $recent = $existingUser->passwordHistories()->latest()->take(5)->get();
            foreach ($recent as $history) {
                if (Hash::check($request->password, $history->password_hash)) {
                    return back()->withInput($request->only('email'))
                        ->withErrors(['password' => __('You cannot reuse a recent password.')]);
                }
            }
        }

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));

                // Store new password history and prune older records
                PasswordHistory::create([
                    'user_id' => $user->id,
                    'password_hash' => $user->password,
                ]);
                $idsToKeep = $user->passwordHistories()->latest()->take(5)->pluck('id');
                $user->passwordHistories()->whereNotIn('id', $idsToKeep)->delete();
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
}
