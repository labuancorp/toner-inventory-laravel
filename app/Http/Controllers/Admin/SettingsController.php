<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function index()
    {
        $logo = Setting::get('agency_logo_path');
        return view('admin.settings', compact('logo'));
    }

    public function updateLogo(Request $request)
    {
        $validated = $request->validate([
            'agency_logo' => ['nullable', 'file', 'mimetypes:image/png,image/jpeg,image/svg+xml', 'max:2048'],
        ]);

        if ($request->hasFile('agency_logo')) {
            // Store in public disk under agency/
            $path = $request->file('agency_logo')->store('agency', 'public');
            Setting::set('agency_logo_path', $path);
            return redirect()->route('admin.settings.index')->with('status', 'Logo updated');
        }

        return redirect()->route('admin.settings.index')->with('status', 'No file uploaded');
    }
}