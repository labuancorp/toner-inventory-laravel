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
    <a href="{{ route('reports.analytics.yearly', ['year' => $year]) }}" class="px-3 py-1.5 text-sm rounded-md {{ request()->routeIs('reports.analytics.yearly') ? 'bg-blue-600 text-white' : 'border border-gray-300 text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700' }} flex items-center gap-2">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
      </svg>
      Yearly
    </a>
  </div>

  <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
    <div>
      <h1 class="text-3xl font-semibold tracking-tight text-gray-900 dark:text-gray-100">Yearly Out by Category</h1>
      <p class="text-gray-600 dark:text-gray-400">Calendar year: {{ $year }}</p>
    </div>
    <div class="flex items-center gap-2">
      <form method="GET" class="flex items-center gap-2" action="{{ route('reports.analytics.yearly') }}">
        <label for="year" class="text-sm font-medium text-gray-700 dark:text-gray-300">Year</label>
        <select name="year" id="year" class="px-3 py-1.5 text-sm border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
          @foreach(range(now()->year, now()->year-10) as $y)
            <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
          @endforeach
        </select>
      </form>
      <a href="{{ route('reports.analytics.yearly.export', ['year' => $year]) }}" class="px-3 py-1.5 text-sm rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700 flex items-center gap-2">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        Export to Excel
      </a>
    </div>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow p-6">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-gray-600">Total OUT ({{ $year }})</p>
          <p class="text-2xl font-semibold text-gray-900">{{ number_format($totalOutYear) }}</p>
        </div>
        <div class="p-3 bg-blue-100 rounded-lg">
          <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
          </svg>
        </div>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 xl:grid-cols-5 gap-6">
    <div class="xl:col-span-3">
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
          <h6 class="text-lg font-semibold text-gray-900 dark:text-gray-100">OUT Quantities by Category</h6>
          <small class="text-gray-600 dark:text-gray-400">Top categories by total OUT</small>
        </div>
        <div class="p-6">
          <canvas id="yearlyOutBarChart" height="240"></canvas>
        </div>
      </div>
    </div>
    <div class="xl:col-span-2">
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
          <h6 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Category Breakdown (Table)</h6>
        </div>
        <div class="p-6">
          @if(collect($rows)->isEmpty())
            <div class="text-center py-8">
              <svg class="w-12 h-12 mx-auto mb-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
              </svg>
              <p class="text-gray-500 dark:text-gray-400">No OUT movements recorded in {{ $year }}.</p>
            </div>
          @else
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total OUT</th>
                  </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                  @foreach($rows as $r)
                  <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $r->category_name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-gray-900 dark:text-gray-100">{{ number_format((int) $r->total_out) }}</td>
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