<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\PasswordHistory;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewUserRegistration;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $a = random_int(2, 9);
        $b = random_int(2, 9);
        session(['register_captcha_expected' => $a + $b]);
        return view('auth.register', compact('a', 'b'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::min(12)->mixedCase()->numbers()->symbols()->uncompromised()],
            'captcha' => ['required', 'integer', function ($attribute, $value, $fail) {
                if ((int) $value !== (int) session('register_captcha_expected')) {
                    $fail(__('Incorrect CAPTCHA answer.'));
                }
            }],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Store initial password history
        PasswordHistory::create([
            'user_id' => $user->id,
            'password_hash' => $user->password,
        ]);

        event(new Registered($user));

        // Notify admins of new registration
        $admins = User::where('role', 'admin')->get();
        if ($admins->isNotEmpty()) {
            Notification::send($admins, new NewUserRegistration($user));
        }

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
