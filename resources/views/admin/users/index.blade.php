@extends('layouts.material')

@section('content')
<div class="space-y-6">
  <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700">
    <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
      <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">User Management</h2>
      <div class="flex items-center gap-2">
        <form method="GET" class="flex items-center gap-2" action="{{ route('admin.users.index') }}">
          <input type="text" class="px-3 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500" name="q" value="{{ $q }}" placeholder="Search name or email">
          <select name="verified" class="px-3 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="" @selected(($verified ?? null)===null)>All</option>
            <option value="1" @selected(($verified ?? null)===true)>Verified</option>
            <option value="0" @selected(($verified ?? null)===false)>Unverified</option>
          </select>
          <button class="px-3 py-1.5 text-sm rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 flex items-center gap-2" type="submit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            Search
          </button>
        </form>
        <a href="{{ route('admin.users.export', request()->query()) }}" class="px-3 py-1.5 text-sm rounded-md border border-gray-300 text-green-700 hover:bg-gray-50 dark:border-gray-600 dark:text-green-400 dark:hover:bg-gray-700 flex items-center gap-2">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
          Export CSV
        </a>
        <a href="{{ route('admin.users.create') }}" class="px-3 py-1.5 text-sm rounded-md bg-blue-600 text-white hover:bg-blue-700 flex items-center gap-2">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
          </svg>
          Invite User
        </a>
      </div>
    </div>
    <div class="p-6">
      <div class="space-y-4">
        <form method="POST" action="{{ route('admin.users.bulk.roles') }}" id="bulkRoleForm" class="flex items-center gap-2">
          @csrf
          <select name="role" class="px-3 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            <option value="">Select Role</option>
            <option value="admin">Admin</option>
            <option value="user">User</option>
          </select>
          <button type="submit" class="px-3 py-1.5 text-sm rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700" disabled id="bulkRoleBtn">Update Roles</button>
        </form>
        
        <form method="POST" action="{{ route('admin.users.bulk.resets') }}" id="bulkPasswordForm" class="flex items-center gap-2">
          @csrf
          <button type="submit" class="px-3 py-1.5 text-sm rounded-md border border-gray-300 text-yellow-700 hover:bg-gray-50 dark:border-gray-600 dark:text-yellow-400 dark:hover:bg-gray-700" disabled id="bulkPasswordBtn">Send Password Reset</button>
        </form>

        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider"><input type="checkbox" id="selectAll" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"></th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Role</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Verified</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Created</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
              @forelse($users as $user)
              <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                <td class="px-6 py-4 whitespace-nowrap"><input type="checkbox" name="user_ids[]" value="{{ $user->id }}" class="user-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500"></td>
                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900 dark:text-gray-100">{{ $user->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-400">{{ $user->email }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' }}">
                    {{ ucfirst($user->role) }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  @if($user->email_verified_at)
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Verified</span>
                  @else
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">Unverified</span>
                  @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-400">{{ $user->created_at->format('M j, Y') }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <a href="{{ route('admin.users.edit', $user) }}" class="px-3 py-1.5 text-sm rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                  </a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="7" class="px-6 py-8 text-center text-gray-600 dark:text-gray-400">
                  <svg class="w-12 h-12 mx-auto mb-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                  </svg>
                  <p>No users found</p>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="mt-6">
          {{ $users->appends(request()->query())->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
<form id="bulkResetForm" method="POST" action="{{ route('admin.users.bulk.resets') }}" class="d-none">
  @csrf
  <input type="hidden" name="ids" id="bulkResetIds">
</form>
<script>
  function toggleSelectAll(el){
    document.querySelectorAll('.row-check').forEach(cb => cb.checked = el.checked);
  }
  function gatherSelectedIds(){
    return Array.from(document.querySelectorAll('.row-check:checked')).map(cb => cb.value);
  }
  function submitBulkResets(){
    const ids = gatherSelectedIds();
    document.getElementById('bulkResetIds').value = JSON.stringify(ids);
    document.getElementById('bulkRoleIds').value = JSON.stringify(ids);
    document.getElementById('bulkResetForm').submit();
  }
  document.getElementById('bulkRoleForm').addEventListener('submit', function(e){
    const ids = gatherSelectedIds();
    document.getElementById('bulkRoleIds').value = JSON.stringify(ids);
  });
</script>
@endsection