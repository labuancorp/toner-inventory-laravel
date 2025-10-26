@extends('layouts.material')

@section('content')
<div class="max-w-2xl mx-auto">
  <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
      <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Edit User</h2>
      <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $user->name }} - {{ $user->email }}</p>
    </div>
    <div class="p-6">
      <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-4">
        @csrf
        @method('PUT')
        <div>
          <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Role</label>
          <select id="role" name="role" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <option value="user" @selected($user->role === 'user')>User</option>
            <option value="manager" @selected($user->role === 'manager')>Manager</option>
            <option value="admin" @selected($user->role === 'admin')>Admin</option>
          </select>
          @error('role')
            <div class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</div>
          @enderror
        </div>
        <div class="flex justify-between gap-2">
          <div class="flex gap-2">
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
              </svg>
              Back
            </a>
            <form method="POST" action="{{ route('admin.users.sendReset', $user) }}" class="inline">
              @csrf
              <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 border border-yellow-300 dark:border-yellow-600 rounded-md text-yellow-700 dark:text-yellow-300 bg-white dark:bg-gray-700 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Send Password Reset
              </button>
            </form>
          </div>
          <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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