@extends('layouts.material')

@section('content')
<div class="row">
  <div class="col-12 mb-4">
    <div class="card">
      <div class="card-header pb-0 d-flex align-items-center justify-content-between">
        <h6 class="mb-0">Users</h6>
        <div class="d-flex align-items-center gap-2">
          <form method="GET" class="d-flex" action="{{ route('admin.users.index') }}">
            <input type="text" class="form-control form-control-sm me-2" name="q" value="{{ $q }}" placeholder="Search name or email">
            <select name="verified" class="form-select form-select-sm me-2" style="width:auto">
              <option value="" @selected(($verified ?? null)===null)>All</option>
              <option value="1" @selected(($verified ?? null)===true)>Verified</option>
              <option value="0" @selected(($verified ?? null)===false)>Unverified</option>
            </select>
            <button class="btn btn-sm btn-outline-secondary" type="submit">Search</button>
          </form>
          <a href="{{ route('admin.users.export', request()->query()) }}" class="btn btn-sm btn-outline-success">Export CSV</a>
          <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-primary">Invite User</a>
        </div>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.users.bulk.roles') }}" id="bulkRoleForm" class="mb-3 d-flex align-items-center gap-2">
          @csrf
          <span class="small text-secondary">Bulk actions:</span>
          <select name="role" class="form-select form-select-sm" style="width:auto">
            <option value="user">User</option>
            <option value="manager">Manager</option>
            <option value="admin">Admin</option>
          </select>
          <input type="hidden" name="ids" id="bulkRoleIds">
          <button type="submit" class="btn btn-sm btn-outline-primary">Apply Role</button>
          <button type="button" class="btn btn-sm btn-outline-secondary" onclick="submitBulkResets()">Send Resets</button>
        </form>
        <div class="table-responsive">
          <table class="table align-items-center">
            <thead>
              <tr>
                <th><input type="checkbox" id="selectAll" onclick="toggleSelectAll(this)"></th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Verified</th>
                <th>Last Login</th>
                <th>Joined</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $u)
              <tr>
                <td><input type="checkbox" class="row-check" value="{{ $u->id }}"></td>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td><span class="badge bg-primary">{{ $u->role ?? 'user' }}</span></td>
                <td>
                  @if($u->email_verified_at)
                    <span class="badge bg-success">Verified</span>
                  @else
                    <span class="badge bg-warning text-dark">Pending</span>
                  @endif
                </td>
                <td>{{ $u->last_login_at?->format('Y-m-d H:i') ?? '-' }}</td>
                <td>{{ $u->created_at?->format('Y-m-d') }}</td>
                <td class="text-end">
                  <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.users.edit', $u) }}">Edit</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="mt-3">
          {{ $users->links() }}
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