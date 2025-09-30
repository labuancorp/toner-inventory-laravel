@extends('layouts.material')

@section('content')
<div class="win11-max-w-2xl win11-mx-auto">
  <div class="win11-card">
    <div class="win11-card-header">
      <h2 class="win11-text-xl win11-font-semibold">Edit User</h2>
      <p class="win11-text-muted win11-text-sm">{{ $user->name }} - {{ $user->email }}</p>
    </div>
    <div class="win11-card-body">
      <form method="POST" action="{{ route('admin.users.update', $user) }}" class="win11-space-y-md">
        @csrf
        @method('PUT')
        <div>
          <label for="role" class="win11-label">Role</label>
          <select id="role" name="role" class="win11-select">
            <option value="user" @selected($user->role === 'user')>User</option>
            <option value="manager" @selected($user->role === 'manager')>Manager</option>
            <option value="admin" @selected($user->role === 'admin')>Admin</option>
          </select>
          @error('role')
            <div class="win11-error">{{ $message }}</div>
          @enderror
        </div>
        <div class="win11-flex win11-justify-between win11-gap-sm">
          <div class="win11-flex win11-gap-sm">
            <a href="{{ route('admin.users.index') }}" class="win11-btn win11-btn-outline">
              <svg class="win11-w-4 win11-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
              </svg>
              Back
            </a>
            <form method="POST" action="{{ route('admin.users.sendReset', $user) }}" class="win11-inline">
              @csrf
              <button type="submit" class="win11-btn win11-btn-outline win11-text-warning">
                <svg class="win11-w-4 win11-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Send Password Reset
              </button>
            </form>
          </div>
          <button type="submit" class="win11-btn win11-btn-primary">
            <svg class="win11-w-4 win11-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection