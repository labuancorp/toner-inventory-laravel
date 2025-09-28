<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocaleController extends Controller
{
    /**
     * Switch the application language and persist in session.
     */
    public function switch(Request $request)
    {
        $validated = $request->validate([
            'locale' => ['required', 'in:en,ms'],
        ]);

        $locale = $validated['locale'];
        session(['locale' => $locale]);
        app()->setLocale($locale);

        // Redirect back or to home if referer missing
        return back()->with('status', __('Language updated'));
    }
}