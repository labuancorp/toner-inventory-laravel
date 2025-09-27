@extends('layouts.material')

@section('content')
<div class="container-fluid">
  <div class="row mb-4">
    <div class="col-12 col-md-8">
      <h1 class="h3">Inventory Health Report</h1>
      <p class="text-muted">Window: last {{ $window }} days</p>
    </div>
    <div class="col-12 col-md-4 text-md-end">
      <form method="GET" class="d-inline-flex align-items-center gap-2">
        <label for="window" class="form-label mb-0">Window</label>
        <select name="window" id="window" class="form-select form-select-sm" onchange="this.form.submit()">
          @foreach([7,14,30,60,90] as $w)
            <option value="{{ $w }}" {{ $w == $window ? 'selected' : '' }}>{{ $w }} days</option>
          @endforeach
        </select>
      </form>
    </div>
  </div>

  <div class="row g-3 mb-4">
    <div class="col-12 col-md-3">
      <div class="card">
        <div class="card-body">
          <div class="text-muted">Total Items</div>
          <div class="h2 mb-0">{{ number_format($summary['total_items']) }}</div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-3">
      <div class="card">
        <div class="card-body">
          <div class="text-muted">Total Quantity</div>
          <div class="h2 mb-0">{{ number_format($summary['total_quantity']) }}</div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-3">
      <div class="card">
        <div class="card-body">
          <div class="text-muted">Low Stock Items</div>
          <div class="h2 mb-0">{{ number_format($summary['low_stock_count']) }}</div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-3">
      <div class="card">
        <div class="card-body">
          <div class="text-muted">Recent Movements</div>
          <div>
            <span class="badge bg-success">In: {{ number_format($recentIn) }}</span>
            <span class="badge bg-danger ms-2">Out: {{ number_format($recentOut) }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header pb-0"><h3 class="card-title">Items Overview</h3></div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-vcenter">
          <thead>
            <tr>
              <th>Name</th>
              <th>Category</th>
              <th>SKU</th>
              <th class="text-end">Qty</th>
              <th class="text-end">Reorder</th>
              <th class="text-end">Avg Daily Out</th>
              <th class="text-end">Days of Cover</th>
              <th class="text-end">Recommended Reorder</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($items as $item)
              <tr>
                <td>
                  <a href="{{ route('items.show', $item) }}" class="text-decoration-none">{{ $item->name }}</a>
                  @if($item->needs_reorder)
                    <span class="badge bg-danger ms-2">Reorder</span>
                  @endif
                </td>
                <td>{{ $item->category?->name }}</td>
                <td>{{ $item->sku }}</td>
                <td class="text-end">{{ $item->quantity }}</td>
                <td class="text-end">{{ $item->reorder_level }}</td>
                <td class="text-end">{{ number_format($item->avg_out, 2) }}</td>
                <td class="text-end">{{ is_infinite($item->cover_days) ? '—' : number_format($item->cover_days, 1) }}</td>
                <td class="text-end">{{ $item->reorder_recommended }}</td>
                <td class="text-end">
                  <a class="btn btn-sm btn-outline-primary" href="{{ route('items.show', $item) }}">View</a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="9" class="text-center text-muted">No items found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection