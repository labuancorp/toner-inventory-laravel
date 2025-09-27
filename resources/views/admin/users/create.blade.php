@extends('layouts.material')

@section('content')
<div class="row">
  <div class="col-12 col-lg-8">
    <div class="card">
      <div class="card-header pb-0 d-flex align-items-center justify-content-between">
        <h6 class="mb-0">Invite User</h6>
        <small class="text-secondary">Create account and optionally send reset</small>
      </div>
      <div class="card-body">
        <form method="POST" action="{{ route('admin.users.store') }}" class="row g-3">
          @csrf
          <div class="col-12">
            <label for="name" class="form-label">Name</label>
            <input id="name" name="name" type="text" class="form-control" value="{{ old('name') }}" required>
            @error('name')
              <div class="text-danger small">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-12">
            <label for="email" class="form-label">Email</label>
            <input id="email" name="email" type="email" class="form-control" value="{{ old('email') }}" required>
            @error('email')
              <div class="text-danger small">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-12">
            <label for="role" class="form-label">Role</label>
            <select id="role" name="role" class="form-select">
              <option value="user" @selected(old('role')==='user')>User</option>
              <option value="manager" @selected(old('role')==='manager')>Manager</option>
              <option value="admin" @selected(old('role')==='admin')>Admin</option>
            </select>
            @error('role')
              <div class="text-danger small">{{ $message }}</div>
            @enderror
          </div>
          <div class="col-12 form-check">
            <input class="form-check-input" type="checkbox" value="1" id="send_reset" name="send_reset" @checked(old('send_reset'))>
            <label class="form-check-label" for="send_reset">
              Send password reset email
            </label>
          </div>
          <div class="col-12 d-flex justify-content-between">
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Create</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection