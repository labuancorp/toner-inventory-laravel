@extends('layouts.app')

@section('content')
<div class="win11-max-w-2xl win11-mx-auto">
  <div class="win11-card">
    <div class="win11-card-header">
      <h2 class="win11-text-xl win11-font-semibold">Invite User</h2>
      <p class="win11-text-muted win11-text-sm">Create account and optionally send reset</p>
    </div>
    <div class="win11-card-body">
      <form method="POST" action="{{ route('admin.users.store') }}" class="win11-space-y-md">
        @csrf
        <div>
          <label for="name" class="win11-label">Name</label>
          <div class="win11-input-group">
            <svg class="win11-input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <input id="name" name="name" type="text" class="win11-input win11-input-with-icon" value="{{ old('name') }}" required>
          </div>
          @error('name')
            <div class="win11-error">{{ $message }}</div>
          @enderror
        </div>
        <div>
          <label for="email" class="win11-label">Email</label>
          <div class="win11-input-group">
            <svg class="win11-input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
            </svg>
            <input id="email" name="email" type="email" class="win11-input win11-input-with-icon" value="{{ old('email') }}" required>
          </div>
          @error('email')
            <div class="win11-error">{{ $message }}</div>
          @enderror
        </div>
        <div>
          <label for="role" class="win11-label">Role</label>
          <select id="role" name="role" class="win11-select">
            <option value="user" @selected(old('role')==='user')>User</option>
            <option value="manager" @selected(old('role')==='manager')>Manager</option>
            <option value="admin" @selected(old('role')==='admin')>Admin</option>
          </select>
          @error('role')
            <div class="win11-error">{{ $message }}</div>
          @enderror
        </div>
        <div class="win11-flex win11-items-center win11-gap-sm">
          <input class="win11-checkbox" type="checkbox" value="1" id="send_reset" name="send_reset" @checked(old('send_reset'))>
          <label class="win11-label" for="send_reset">
            Send password reset email
          </label>
        </div>
        <div class="win11-flex win11-justify-between win11-gap-sm">
          <a href="{{ route('admin.users.index') }}" class="win11-btn win11-btn-outline">
            <svg class="win11-w-4 win11-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Cancel
          </a>
          <button type="submit" class="win11-btn win11-btn-primary">
            <svg class="win11-w-4 win11-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Create User
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection