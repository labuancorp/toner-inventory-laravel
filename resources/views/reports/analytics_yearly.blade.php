@extends('layouts.material')

@section('content')
<div class="win11-space-y-lg">
  <!-- Tabs: Overview ↔ Yearly -->
  <div class="win11-flex win11-items-center win11-gap-sm">
    <a href="{{ route('reports.analytics') }}" class="win11-btn {{ request()->routeIs('reports.analytics') ? 'win11-btn-primary' : 'win11-btn-outline' }} win11-btn-sm">
      <svg class="win11-w-6 win11-h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
      </svg>
      Overview
    </a>
    <a href="{{ route('reports.analytics.yearly', ['year' => $year]) }}" class="win11-btn {{ request()->routeIs('reports.analytics.yearly') ? 'win11-btn-primary' : 'win11-btn-outline' }} win11-btn-sm">
      <svg class="win11-w-6 win11-h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
      </svg>
      Yearly
    </a>
  </div>

  <div class="win11-flex win11-flex-col lg:win11-flex-row win11-items-start lg:win11-items-center win11-justify-between win11-gap-md">
    <div>
      <h1 class="win11-text-3xl win11-font-semibold win11-tracking-tight">Yearly Out by Category</h1>
      <p class="win11-text-secondary">Calendar year: {{ $year }}</p>
    </div>
    <div class="win11-flex win11-items-center win11-gap-sm">
      <form method="GET" class="win11-flex win11-items-center win11-gap-sm" action="{{ route('reports.analytics.yearly') }}">
        <label for="year" class="win11-label">Year</label>
        <select name="year" id="year" class="win11-select win11-select-sm" onchange="this.form.submit()">
          @foreach(range(now()->year, now()->year-10) as $y)
            <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
          @endforeach
        </select>
      </form>
      <a href="{{ route('reports.analytics.yearly.export', ['year' => $year]) }}" class="win11-btn win11-btn-outline win11-btn-sm">
        <svg class="win11-w-6 win11-h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        Export to Excel
      </a>
    </div>
  </div>

  <div class="win11-grid win11-grid-cols-1 md:win11-grid-cols-2 win11-gap-md">
    <div class="win11-card win11-p-md">
      <div class="win11-flex win11-items-center win11-justify-between">
        <div>
          <p class="win11-text-sm win11-text-secondary">Total OUT ({{ $year }})</p>
          <p class="win11-text-2xl win11-font-semibold">{{ number_format($totalOutYear) }}</p>
        </div>
        <div class="win11-p-3 win11-bg-accent/10 win11-rounded-lg">
          <svg class="win11-w-8 win11-h-8 win11-text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
          </svg>
        </div>
      </div>
    </div>
  </div>

  <div class="win11-grid win11-grid-cols-1 xl:win11-grid-cols-5 win11-gap-md">
    <div class="xl:win11-col-span-3">
      <div class="win11-card">
        <div class="win11-card-header win11-flex win11-items-center win11-justify-between">
          <h6 class="win11-text-lg win11-font-semibold">OUT Quantities by Category</h6>
          <small class="win11-text-secondary">Top categories by total OUT</small>
        </div>
        <div class="win11-card-body">
          <canvas id="yearlyOutBarChart" height="240"></canvas>
        </div>
      </div>
    </div>
    <div class="xl:win11-col-span-2">
      <div class="win11-card">
        <div class="win11-card-header">
          <h6 class="win11-text-lg win11-font-semibold">Category Breakdown (Table)</h6>
        </div>
        <div class="win11-card-body">
          @if(collect($rows)->isEmpty())
            <div class="win11-text-center win11-py-lg">
              <svg class="win11-w-12 win11-h-12 win11-mx-auto win11-mb-sm win11-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
              </svg>
              <p class="win11-text-muted">No OUT movements recorded in {{ $year }}.</p>
            </div>
          @else
            <div class="win11-overflow-x-auto">
              <table class="win11-table">
                <thead>
                  <tr>
                    <th>Category</th>
                    <th class="win11-text-right">Total OUT</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($rows as $r)
                  <tr>
                    <td>{{ $r->category_name }}</td>
                    <td class="win11-text-right">{{ number_format((int) $r->total_out) }}</td>
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