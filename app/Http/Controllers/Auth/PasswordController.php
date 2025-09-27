<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\PasswordHistory;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::min(12)->mixedCase()->numbers()->symbols()->uncompromised(), 'confirmed'],
        ]);

        // Prevent reuse of recent passwords (last 5)
        $recent = $request->user()->passwordHistories()->latest()->take(5)->get();
        foreach ($recent as $history) {
            if (Hash::check($validated['password'], $history->password_hash)) {
                return back()->withErrors([
                    'updatePassword' => __('You cannot reuse a recent password.'),
                ]);
            }
        }

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        // Store new password history and prune older records
        PasswordHistory::create([
            'user_id' => $request->user()->id,
            'password_hash' => $request->user()->password,
        ]);
        $idsToKeep = $request->user()->passwordHistories()->latest()->take(5)->pluck('id');
        $request->user()->passwordHistories()->whereNotIn('id', $idsToKeep)->delete();

        return back()->with('status', 'password-updated');
    }
}
