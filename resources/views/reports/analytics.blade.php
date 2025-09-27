@extends('layouts.material')

@section('content')
<div class="container-fluid">
  <!-- Tabs: Overview ↔ Yearly -->
  <div class="row mb-3">
    <div class="col-12">
      <div class="d-flex align-items-center gap-2">
        <a href="{{ route('reports.analytics') }}" class="btn btn-sm {{ request()->routeIs('reports.analytics') ? 'btn-primary' : 'btn-outline-primary' }}">Overview</a>
        <a href="{{ route('reports.analytics.yearly', ['year' => now()->year]) }}" class="btn btn-sm {{ request()->routeIs('reports.analytics.yearly') ? 'btn-primary' : 'btn-outline-primary' }}">Yearly</a>
      </div>
    </div>
  </div>

  <div class="row mb-4 align-items-center">
    <div class="col-12 col-md-8">
      <h1 class="h3">Advanced Analytics</h1>
      <p class="text-muted">Window: last {{ $window }} days</p>
    </div>
    <div class="col-12 col-md-4 text-md-end">
      <form method="GET" class="d-inline-flex align-items-center gap-2">
        <label for="window" class="form-label mb-0">Window</label>
        <select name="window" id="window" class="form-select form-select-sm" onchange="this.form.submit()">
          @foreach([7,14,30,60,90,180] as $w)
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
          <div class="text-muted">ABC Classification</div>
          <div>
            <span class="badge bg-primary">A: {{ $summary['abc']['A'] }}</span>
            <span class="badge bg-info ms-2">B: {{ $summary['abc']['B'] }}</span>
            <span class="badge bg-secondary ms-2">C: {{ $summary['abc']['C'] }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12 col-xl-8 mb-4">
      <div class="card">
        <div class="card-header pb-0 d-flex align-items-center justify-content-between">
          <h6 class="mb-0">{{ $window }}-Day Stock Movements</h6>
          <small class="text-secondary">Daily totals for In/Out</small>
        </div>
        <div class="card-body">
          <canvas id="analyticsMovementsChart" height="140"></canvas>
        </div>
      </div>
    </div>
    <div class="col-12 col-xl-4 mb-4">
      <div class="card">
        <div class="card-header pb-0">
          <h6>Category Distribution</h6>
          <small class="text-secondary">Current stock by category</small>
        </div>
        <div class="card-body">
          <canvas id="categoryPieChart" height="140"></canvas>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12 mb-4">
      <div class="card">
        <div class="card-header pb-0">
          <h6>Top {{ min(10, count($fastMovers)) }} Fast-Moving Items (Out)</h6>
        </div>
        <div class="card-body">
          @if(empty($fastMovers) || collect($fastMovers)->isEmpty())
            <p class="text-muted">Not enough movement data in the selected window.</p>
          @else
            <div class="table-responsive">
              <table class="table align-items-center">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>SKU</th>
                    <th>Category</th>
                    <th class="text-end">Total Out</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($fastMovers as $row)
                  <tr>
                    <td>
                      @if($row['item'])
                        <a href="{{ route('items.show', $row['item']) }}" class="text-decoration-none">{{ $row['item']->name }}</a>
                      @else
                        <span class="text-muted">[deleted]</span>
                      @endif
                    </td>
                    <td>{{ $row['item']?->sku }}</td>
                    <td>{{ $row['item']?->category?->name }}</td>
                    <td class="text-end">{{ number_format($row['total_out']) }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  window.__analyticsTimeseries = @json($timeseries ?? null);
  window.__categoryDistribution = @json($categoryDistribution ?? null);
</script>
@endsection