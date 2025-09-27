@extends('layouts.material')

@section('content')
<div class="container-fluid">
  <!-- Tabs: Overview ↔ Yearly -->
  <div class="row mb-3">
    <div class="col-12">
      <div class="d-flex align-items-center gap-2">
        <a href="{{ route('reports.analytics') }}" class="btn btn-sm {{ request()->routeIs('reports.analytics') ? 'btn-primary' : 'btn-outline-primary' }}">Overview</a>
        <a href="{{ route('reports.analytics.yearly', ['year' => $year]) }}" class="btn btn-sm {{ request()->routeIs('reports.analytics.yearly') ? 'btn-primary' : 'btn-outline-primary' }}">Yearly</a>
      </div>
    </div>
  </div>

  <div class="row mb-4 align-items-center">
    <div class="col-12 col-md-8">
      <h1 class="h3">Yearly Out by Category</h1>
      <p class="text-muted">Calendar year: {{ $year }}</p>
    </div>
    <div class="col-12 col-md-4 text-md-end">
      <form method="GET" class="d-inline-flex align-items-center gap-2" action="{{ route('reports.analytics.yearly') }}">
        <label for="year" class="form-label mb-0">Year</label>
        <select name="year" id="year" class="form-select form-select-sm" onchange="this.form.submit()">
          @foreach(range(now()->year, now()->year-10) as $y)
            <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
          @endforeach
        </select>
      </form>
      <a href="{{ route('reports.analytics.yearly.export', ['year' => $year]) }}" class="btn btn-outline-primary btn-sm ms-2">
        Export to Excel
      </a>
    </div>
  </div>

  <div class="row g-3 mb-4">
    <div class="col-12 col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="text-muted">Total OUT ({{ $year }})</div>
          <div class="h2 mb-0">{{ number_format($totalOutYear) }}</div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12 col-xl-7 mb-4">
      <div class="card">
        <div class="card-header pb-0 d-flex align-items-center justify-content-between">
          <h6 class="mb-0">OUT Quantities by Category</h6>
          <small class="text-secondary">Top categories by total OUT</small>
        </div>
        <div class="card-body">
          <canvas id="yearlyOutBarChart" height="160"></canvas>
        </div>
      </div>
    </div>
    <div class="col-12 col-xl-5 mb-4">
      <div class="card">
        <div class="card-header pb-0">
          <h6>Category Breakdown (Table)</h6>
        </div>
        <div class="card-body">
          @if(collect($rows)->isEmpty())
            <p class="text-muted">No OUT movements recorded in {{ $year }}.</p>
          @else
            <div class="table-responsive">
              <table class="table align-items-center">
                <thead>
                  <tr>
                    <th>Category</th>
                    <th class="text-end">Total OUT</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($rows as $r)
                  <tr>
                    <td>{{ $r->category_name }}</td>
                    <td class="text-end">{{ number_format((int) $r->total_out) }}</td>
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
  window.__yearlyByCategory = @json(['labels' => $labels, 'series' => $series]);
</script>
@endsection