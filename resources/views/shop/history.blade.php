@extends('layouts.material')
@section('title', 'Shop History')
@section('content')
<div class="container-fluid">
  <div class="row mb-4 align-items-center">
    <div class="col-12 col-md-8">
      <h1 class="h3 mb-1">Toner Transactions History</h1>
      <p class="text-muted">Full audit trail with accurate timestamps</p>
    </div>
    <div class="col-12 col-md-4 text-md-end">
      <a class="btn btn-outline-secondary btn-sm" href="{{ route('shop.history.export', request()->query()) }}">
        <i class="ti ti-file-export" aria-hidden="true"></i>
        Export CSV
      </a>
    </div>
  </div>

  <!-- Filters -->
  <div class="card mb-4">
    <div class="card-header pb-0"><h6>Search & Filters</h6></div>
    <div class="card-body">
      <form method="GET" class="row g-3">
        <div class="col-12 col-md-3">
          <label for="start_date" class="form-label">Start date</label>
          <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}">
        </div>
        <div class="col-12 col-md-3">
          <label for="end_date" class="form-label">End date</label>
          <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date') }}">
        </div>
        <div class="col-12 col-md-3">
          <label for="user_id" class="form-label">User</label>
          <select id="user_id" name="user_id" class="form-select">
            <option value="">All users</option>
            @foreach($users as $u)
              <option value="{{ $u->id }}" {{ (string)$u->id === (string)request('user_id') ? 'selected' : '' }}>{{ $u->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-12 col-md-3">
          <label for="category_id" class="form-label">Toner type (category)</label>
          <select id="category_id" name="category_id" class="form-select">
            <option value="">All types</option>
            @foreach($categories as $c)
              <option value="{{ $c->id }}" {{ (string)$c->id === (string)request('category_id') ? 'selected' : '' }}>{{ $c->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-12 col-md-4">
          <label for="item_id" class="form-label">Specific toner (optional)</label>
          <select id="item_id" name="item_id" class="form-select">
            <option value="">All toners</option>
            @foreach($items as $i)
              <option value="{{ $i->id }}" {{ (string)$i->id === (string)request('item_id') ? 'selected' : '' }}>{{ $i->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-12 col-md-8 d-flex align-items-end justify-content-md-end gap-2">
          <button type="submit" class="btn btn-primary">Apply filters</button>
          <a href="{{ route('shop.history') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
      </form>
    </div>
  </div>

  <!-- Summary -->
  <div class="row g-3 mb-4">
    <div class="col-12 col-md-3">
      <div class="card"><div class="card-body"><div class="text-muted">Total Transactions</div><div class="h3 mb-0">{{ number_format($total) }}</div></div></div>
    </div>
    <div class="col-12 col-md-3">
      <div class="card"><div class="card-body"><div class="text-muted">Total Out (Take)</div><div class="h3 mb-0 text-danger">{{ number_format($totalOut) }}</div></div></div>
    </div>
    <div class="col-12 col-md-3">
      <div class="card"><div class="card-body"><div class="text-muted">Total In (Order)</div><div class="h3 mb-0 text-success">{{ number_format($totalIn) }}</div></div></div>
    </div>
  </div>

  <!-- Transactions table -->
  <div class="card">
    <div class="card-header pb-0"><h6>Chronological Transactions</h6><small class="text-secondary">Accurate date and timestamp for each entry</small></div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-vcenter align-middle">
          <thead>
            <tr>
              <th>Date/Time</th>
              <th>User</th>
              <th>Toner</th>
              <th>SKU</th>
              <th>Category</th>
              <th class="text-end">Quantity</th>
              <th>Type</th>
            </tr>
          </thead>
          <tbody>
          @forelse($movements as $m)
            <tr>
              <td>{{ $m->created_at->toDayDateTimeString() }}</td>
              <td>{{ optional($m->user)->name }}</td>
              <td>
                @if($m->item)
                  <a href="{{ route('items.show', $m->item) }}" class="text-decoration-none">{{ $m->item->name }}</a>
                @else
                  <span class="text-muted">(deleted)</span>
                @endif
              </td>
              <td>{{ optional($m->item)->sku }}</td>
              <td>{{ optional(optional($m->item)->category)->name }}</td>
              <td class="text-end">{{ number_format($m->quantity) }}</td>
              <td>
                @if($m->type === 'out')
                  <span class="badge bg-danger">Take</span>
                @else
                  <span class="badge bg-success">Order</span>
                @endif
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-muted">No transactions found for the selected filters.</td>
            </tr>
          @endforelse
          </tbody>
        </table>
      </div>
      <div class="mt-3 d-flex justify-content-end">
        {{ $movements->withQueryString()->links() }}
      </div>
    </div>
  </div>
</div>
@endsection