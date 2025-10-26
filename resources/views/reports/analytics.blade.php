@extends('layouts.material')

@section('content')
<div class="space-y-6">
  <!-- Tabs: Overview ↔ Yearly -->
  <div class="flex items-center gap-2">
    <a href="{{ route('reports.analytics') }}" class="px-3 py-1.5 text-sm rounded-md {{ request()->routeIs('reports.analytics') ? 'bg-blue-600 text-white' : 'border border-gray-300 text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700' }} flex items-center gap-2">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
      </svg>
      Overview
    </a>
    <a href="{{ route('reports.analytics.yearly', ['year' => now()->year]) }}" class="px-3 py-1.5 text-sm rounded-md {{ request()->routeIs('reports.analytics.yearly') ? 'bg-blue-600 text-white' : 'border border-gray-300 text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700' }} flex items-center gap-2">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
      </svg>
      Yearly
    </a>
  </div>

  <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
    <div>
      <h1 class="text-3xl font-semibold tracking-tight text-gray-900 dark:text-gray-100">Advanced Analytics</h1>
      <p class="text-gray-600 dark:text-gray-400">Window: last {{ $window }} days</p>
    </div>
    <div>
      <form method="GET" class="flex items-center gap-2">
        <label for="window" class="text-sm font-medium text-gray-700 dark:text-gray-300">Window</label>
        <select name="window" id="window" class="px-3 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
          @foreach([7,14,30,60,90,180] as $w)
            <option value="{{ $w }}" {{ $w == $window ? 'selected' : '' }}>{{ $w }} days</option>
          @endforeach
        </select>
      </form>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-4">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-gray-600 dark:text-gray-400">Total Items</p>
          <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ number_format($summary['total_items']) }}</p>
        </div>
        <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
          <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
          </svg>
        </div>
      </div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-4">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-gray-600 dark:text-gray-400">Total Quantity</p>
          <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ number_format($summary['total_quantity']) }}</p>
        </div>
        <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg">
          <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
          </svg>
        </div>
      </div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-4">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-gray-600 dark:text-gray-400">Low Stock Items</p>
          <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ number_format($summary['low_stock_count']) }}</p>
        </div>
        <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
          <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
          </svg>
        </div>
      </div>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 p-4">
      <div>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">ABC Classification</p>
        <div class="flex flex-wrap gap-1">
          <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">A: {{ $summary['abc']['A'] }}</span>
          <span class="px-2 py-1 text-xs rounded-full bg-cyan-100 text-cyan-800 dark:bg-cyan-900 dark:text-cyan-200">B: {{ $summary['abc']['B'] }}</span>
          <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">C: {{ $summary['abc']['C'] }}</span>
        </div>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
    <div class="xl:col-span-2">
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
          <h6 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $window }}-Day Stock Movements</h6>
          <small class="text-gray-600 dark:text-gray-400">Daily totals for In/Out</small>
        </div>
        <div class="p-4">
          <canvas id="analyticsMovementsChart" height="240"></canvas>
        </div>
      </div>
    </div>
    <div>
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
          <h6 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Category Distribution</h6>
          <small class="text-gray-600 dark:text-gray-400">Current stock by category</small>
        </div>
        <div class="p-4">
          <canvas id="categoryPieChart" height="240"></canvas>
        </div>
      </div>
    </div>
  </div>

  <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
      <h6 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Top {{ min(10, count($fastMovers)) }} Fast-Moving Items (Out)</h6>
    </div>
    <div class="p-4">
      @if(empty($fastMovers) || collect($fastMovers)->isEmpty())
        <div class="text-center py-6">
          <svg class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
          </svg>
          <p class="text-gray-500 dark:text-gray-400">Not enough movement data in the selected window.</p>
        </div>
      @else
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">SKU</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Category</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total Out</th>
              </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
              @foreach($fastMovers as $row)
              <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                  @if($row['item'])
                    <a href="{{ route('items.show', $row['item']) }}" class="text-blue-600 dark:text-blue-400 hover:underline">{{ $row['item']->name }}</a>
                  @else
                    <span class="text-gray-500 dark:text-gray-400">[deleted]</span>
                  @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $row['item']?->sku }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $row['item']?->category?->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-gray-900 dark:text-gray-100">{{ number_format($row['total_out']) }}</td>
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