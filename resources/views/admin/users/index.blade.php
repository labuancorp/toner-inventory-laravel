@extends('layouts.material')

@section('content')
<div class="win11-space-y-lg">
  <div class="win11-card">
    <div class="win11-card-header win11-flex win11-items-center win11-justify-between">
      <h2 class="win11-text-xl win11-font-semibold">User Management</h2>
      <div class="win11-flex win11-items-center win11-gap-sm">
        <form method="GET" class="win11-flex win11-items-center win11-gap-sm" action="{{ route('admin.users.index') }}">
          <input type="text" class="win11-input win11-input-sm" name="q" value="{{ $q }}" placeholder="Search name or email">
          <select name="verified" class="win11-select win11-select-sm">
            <option value="" @selected(($verified ?? null)===null)>All</option>
            <option value="1" @selected(($verified ?? null)===true)>Verified</option>
            <option value="0" @selected(($verified ?? null)===false)>Unverified</option>
          </select>
          <button class="win11-btn win11-btn-outline win11-btn-sm" type="submit">
            <svg class="win11-w-4 win11-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            Search
          </button>
        </form>
        <a href="{{ route('admin.users.export', request()->query()) }}" class="win11-btn win11-btn-outline win11-btn-sm win11-text-success">
          <svg class="win11-w-4 win11-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
          Export CSV
        </a>
        <a href="{{ route('admin.users.create') }}" class="win11-btn win11-btn-primary win11-btn-sm">
          <svg class="win11-w-4 win11-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
          </svg>
          Invite User
        </a>
      </div>
    </div>
    <div class="win11-card-body">
      <div class="win11-space-y-md">
        <form method="POST" action="{{ route('admin.users.bulk.roles') }}" id="bulkRoleForm" class="win11-flex win11-items-center win11-gap-sm">
          @csrf
          <select name="role" class="win11-select win11-select-sm" required>
            <option value="">Select Role</option>
            <option value="admin">Admin</option>
            <option value="user">User</option>
          </select>
          <button type="submit" class="win11-btn win11-btn-outline win11-btn-sm" disabled id="bulkRoleBtn">Update Roles</button>
        </form>
        
        <form method="POST" action="{{ route('admin.users.bulk.resets') }}" id="bulkPasswordForm" class="win11-flex win11-items-center win11-gap-sm">
          @csrf
          <button type="submit" class="win11-btn win11-btn-outline win11-btn-sm win11-text-warning" disabled id="bulkPasswordBtn">Send Password Reset</button>
        </form>

        <div class="win11-overflow-x-auto">
          <table class="win11-table">
            <thead>
              <tr>
                <th><input type="checkbox" id="selectAll" class="win11-checkbox"></th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Verified</th>
                <th>Created</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($users as $user)
              <tr>
                <td><input type="checkbox" name="user_ids[]" value="{{ $user->id }}" class="user-checkbox win11-checkbox"></td>
                <td class="win11-font-medium">{{ $user->name }}</td>
                <td class="win11-text-muted">{{ $user->email }}</td>
                <td>
                  <span class="win11-badge {{ $user->role === 'admin' ? 'win11-badge-danger' : 'win11-badge-primary' }}">
                    {{ ucfirst($user->role) }}
                  </span>
                </td>
                <td>
                  @if($user->email_verified_at)
                    <span class="win11-badge win11-badge-success">Verified</span>
                  @else
                    <span class="win11-badge win11-badge-warning">Unverified</span>
                  @endif
                </td>
                <td class="win11-text-muted">{{ $user->created_at->format('M j, Y') }}</td>
                <td>
                  <a href="{{ route('admin.users.edit', $user) }}" class="win11-btn win11-btn-outline win11-btn-sm">
                    <svg class="win11-w-4 win11-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                  </a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="7" class="win11-text-center win11-text-muted win11-py-lg">
                  <svg class="win11-w-12 win11-h-12 win11-mx-auto win11-mb-sm win11-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                  </svg>
                  <p>No users found</p>
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="win11-mt-lg">
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