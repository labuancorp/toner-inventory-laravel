@extends('layouts.app')

@section('content')
<div class="win11-space-y-lg">
  <!-- Tabs: Overview ↔ Yearly -->
  <div class="win11-flex win11-items-center win11-gap-sm">
    <a href="{{ route('reports.analytics') }}" class="win11-btn {{ request()->routeIs('reports.analytics') ? 'win11-btn-primary' : 'win11-btn-outline' }} win11-btn-sm">
      <svg class="win11-w-4 win11-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
      </svg>
      Overview
    </a>
    <a href="{{ route('reports.analytics.yearly', ['year' => now()->year]) }}" class="win11-btn {{ request()->routeIs('reports.analytics.yearly') ? 'win11-btn-primary' : 'win11-btn-outline' }} win11-btn-sm">
      <svg class="win11-w-4 win11-h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
      </svg>
      Yearly
    </a>
  </div>

  <div class="win11-flex win11-flex-col lg:win11-flex-row win11-items-start lg:win11-items-center win11-justify-between win11-gap-md">
    <div>
      <h1 class="win11-text-3xl win11-font-semibold win11-tracking-tight">Advanced Analytics</h1>
      <p class="win11-text-secondary">Window: last {{ $window }} days</p>
    </div>
    <div>
      <form method="GET" class="win11-flex win11-items-center win11-gap-sm">
        <label for="window" class="win11-label">Window</label>
        <select name="window" id="window" class="win11-select win11-select-sm" onchange="this.form.submit()">
          @foreach([7,14,30,60,90,180] as $w)
            <option value="{{ $w }}" {{ $w == $window ? 'selected' : '' }}>{{ $w }} days</option>
          @endforeach
        </select>
      </form>
    </div>
  </div>

  <div class="win11-grid win11-grid-cols-1 md:win11-grid-cols-2 lg:win11-grid-cols-4 win11-gap-md">
    <div class="win11-card win11-p-md">
      <div class="win11-flex win11-items-center win11-justify-between">
        <div>
          <p class="win11-text-sm win11-text-secondary">Total Items</p>
          <p class="win11-text-2xl win11-font-semibold">{{ number_format($summary['total_items']) }}</p>
        </div>
        <div class="win11-p-3 win11-bg-primary/10 win11-rounded-lg">
          <svg class="win11-w-6 win11-h-6 win11-text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
          </svg>
        </div>
      </div>
    </div>
    <div class="win11-card win11-p-md">
      <div class="win11-flex win11-items-center win11-justify-between">
        <div>
          <p class="win11-text-sm win11-text-secondary">Total Quantity</p>
          <p class="win11-text-2xl win11-font-semibold">{{ number_format($summary['total_quantity']) }}</p>
        </div>
        <div class="win11-p-3 win11-bg-accent/10 win11-rounded-lg">
          <svg class="win11-w-6 win11-h-6 win11-text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
          </svg>
        </div>
      </div>
    </div>
    <div class="win11-card win11-p-md">
      <div class="win11-flex win11-items-center win11-justify-between">
        <div>
          <p class="win11-text-sm win11-text-secondary">Low Stock Items</p>
          <p class="win11-text-2xl win11-font-semibold">{{ number_format($summary['low_stock_count']) }}</p>
        </div>
        <div class="win11-p-3 win11-bg-warning/10 win11-rounded-lg">
          <svg class="win11-w-6 win11-h-6 win11-text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
          </svg>
        </div>
      </div>
    </div>
    <div class="win11-card win11-p-md">
      <div>
        <p class="win11-text-sm win11-text-secondary win11-mb-sm">ABC Classification</p>
        <div class="win11-flex win11-flex-wrap win11-gap-xs">
          <span class="win11-badge win11-badge-primary">A: {{ $summary['abc']['A'] }}</span>
          <span class="win11-badge win11-badge-info">B: {{ $summary['abc']['B'] }}</span>
          <span class="win11-badge win11-badge-secondary">C: {{ $summary['abc']['C'] }}</span>
        </div>
      </div>
    </div>
  </div>

  <div class="win11-grid win11-grid-cols-1 xl:win11-grid-cols-3 win11-gap-md">
    <div class="xl:win11-col-span-2">
      <div class="win11-card">
        <div class="win11-card-header win11-flex win11-items-center win11-justify-between">
          <h6 class="win11-text-lg win11-font-semibold">{{ $window }}-Day Stock Movements</h6>
          <small class="win11-text-secondary">Daily totals for In/Out</small>
        </div>
        <div class="win11-card-body">
          <canvas id="analyticsMovementsChart" height="140"></canvas>
        </div>
      </div>
    </div>
    <div>
      <div class="win11-card">
        <div class="win11-card-header">
          <h6 class="win11-text-lg win11-font-semibold">Category Distribution</h6>
          <small class="win11-text-secondary">Current stock by category</small>
        </div>
        <div class="win11-card-body">
          <canvas id="categoryPieChart" height="140"></canvas>
        </div>
      </div>
    </div>
  </div>

  <div class="win11-card">
    <div class="win11-card-header">
      <h6 class="win11-text-lg win11-font-semibold">Top {{ min(10, count($fastMovers)) }} Fast-Moving Items (Out)</h6>
    </div>
    <div class="win11-card-body">
      @if(empty($fastMovers) || collect($fastMovers)->isEmpty())
        <div class="win11-text-center win11-py-lg">
          <svg class="win11-w-12 win11-h-12 win11-mx-auto win11-mb-sm win11-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
          </svg>
          <p class="win11-text-muted">Not enough movement data in the selected window.</p>
        </div>
      @else
        <div class="win11-overflow-x-auto">
          <table class="win11-table">
            <thead>
              <tr>
                <th>Name</th>
                <th>SKU</th>
                <th>Category</th>
                <th class="win11-text-right">Total Out</th>
              </tr>
            </thead>
            <tbody>
              @foreach($fastMovers as $row)
              <tr>
                <td>
                  @if($row['item'])
                    <a href="{{ route('items.show', $row['item']) }}" class="win11-link">{{ $row['item']->name }}</a>
                  @else
                    <span class="win11-text-muted">[deleted]</span>
                  @endif
                </td>
                <td>{{ $row['item']?->sku }}</td>
                <td>{{ $row['item']?->category?->name }}</td>
                <td class="win11-text-right">{{ number_format($row['total_out']) }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>
</div>

<script>
  window.__analyticsTimeseries = @json($timeseries ?? null);
  window.__categoryDistribution = @json($categoryDistribution ?? null);
</script>
@endsection