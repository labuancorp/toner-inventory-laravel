<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UserManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin,manager']);
    }

    public function index(Request $request)
    {
        $q = $request->get('q');
        $verified = $request->boolean('verified', null);
        $users = User::query()
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->when(!is_null($verified), function ($query) use ($verified) {
                if ($verified) {
                    $query->whereNotNull('email_verified_at');
                } else {
                    $query->whereNull('email_verified_at');
                }
            })
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'q', 'verified'));
    }

    public function create()
    {
        Gate::authorize('manage-users');
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('manage-users');
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'in:admin,manager,user'],
            'send_reset' => ['nullable', 'boolean'],
        ]);

        $tempPassword = Str::random(24);
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => Hash::make($tempPassword),
            'email_verified_at' => null,
        ]);

        if (!empty($validated['send_reset'])) {
            Password::sendResetLink(['email' => $user->email]);
        }

        return redirect()->route('admin.users.index')->with('status', 'User invited');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => ['required', 'in:admin,manager,user'],
        ]);
        $user->update($validated);
        return redirect()->route('admin.users.index')->with('status', 'User updated');
    }

    public function sendReset(User $user)
    {
        Password::sendResetLink(['email' => $user->email]);
        return back()->with('status', 'Password reset link sent');
    }

    public function bulkUpdateRoles(Request $request)
    {
        Gate::authorize('manage-users');
        $request->validate([
            'role' => ['required', 'in:admin,manager,user'],
            'ids' => ['required'],
        ]);
        $ids = $request->input('ids');
        if (is_string($ids)) {
            $ids = json_decode($ids, true) ?? [];
        }
        $ids = array_filter(array_map('intval', (array) $ids));
        $count = User::whereIn('id', $ids)->update(['role' => $request->input('role')]);
        return back()->with('status', "Updated roles for {$count} users");
    }

    public function bulkSendResets(Request $request)
    {
        Gate::authorize('manage-users');
        $request->validate(['ids' => ['required']]);
        $ids = $request->input('ids');
        if (is_string($ids)) {
            $ids = json_decode($ids, true) ?? [];
        }
        $ids = array_filter(array_map('intval', (array) $ids));
        $users = User::whereIn('id', $ids)->get();
        foreach ($users as $user) {
            Password::sendResetLink(['email' => $user->email]);
        }
        return back()->with('status', 'Password reset links sent');
    }

    public function export(Request $request): StreamedResponse
    {
        Gate::authorize('manage-users');
        $q = $request->get('q');
        $verified = $request->boolean('verified', null);

        $query = User::query()
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->when(!is_null($verified), function ($query) use ($verified) {
                if ($verified) {
                    $query->whereNotNull('email_verified_at');
                } else {
                    $query->whereNull('email_verified_at');
                }
            })
            ->orderBy('name');

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="users.csv"',
        ];

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Name', 'Email', 'Role', 'Verified', 'Last Login', 'Joined']);
            $query->chunk(200, function ($chunk) use ($handle) {
                foreach ($chunk as $u) {
                    fputcsv($handle, [
                        $u->name,
                        $u->email,
                        $u->role ?? 'user',
                        $u->email_verified_at ? 'Yes' : 'No',
                        optional($u->last_login_at)->format('Y-m-d H:i:s'),
                        optional($u->created_at)->format('Y-m-d H:i:s'),
                    ]);
                }
            });
            fclose($handle);
        }, 'users.csv', $headers);
    }
}