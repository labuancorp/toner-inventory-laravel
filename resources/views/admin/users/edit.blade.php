@extends('layouts.material')

@section('content')
<div class="row">
  <div class="col-12 col-lg-8">
    <div class="card">
      <div class="card-header pb-0 d-flex align-items-center justify-content-between">
        <h6 class="mb-0">Edit User</h6>
        <small class="text-secondary">{{ $user->email }}</small>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="row g-3">
          @csrf
          @method('PUT')
          <div class="col-12">
            <label for="role" class="form-label">Role</label>
            <select id="role" name="role" class="form-select">
              <option value="user" @selected($user->role === 'user')>User</option>
              <option value="manager" @selected($user->role === 'manager')>Manager</option>
              <option value="admin" @selected($user->role === 'admin')>Admin</option>
            </select>
            @error('role')
              <div class="text-danger small">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-12 d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Save</button>
            <div>
              <form method="POST" action="{{ route('admin.users.sendReset', $user) }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-secondary">Send Password Reset</button>
              </form>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection