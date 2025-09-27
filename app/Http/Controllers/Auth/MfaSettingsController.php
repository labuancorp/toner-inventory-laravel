<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class MfaSettingsController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'mfa_enabled' => ['nullable', 'boolean'],
        ]);

        $user = $request->user();
        $enabled = (bool) $request->boolean('mfa_enabled');
        $user->mfa_enabled = $enabled;
        $user->mfa_method = $enabled ? 'email' : null;
        $user->save();

        return back()->with('status', $enabled ? 'mfa-enabled' : 'mfa-disabled');
    }
}