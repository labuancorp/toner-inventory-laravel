<x-layouts.public>
    <div class="py-8 md:py-10">
        <div class="px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
            <div class="bg-white/90 bg-gradient-soft backdrop-blur-sm shadow-sm rounded-lg p-6 md:p-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-2xl font-semibold tracking-tight">Usage Reports</h1>
                        <p class="text-sm text-gray-600">Window: last {{ $window }} days</p>
                    </div>
                    <form method="GET" class="flex items-center gap-2" aria-label="Select reporting window">
                        <label for="window" class="text-sm text-gray-700">Window</label>
                        <select name="window" id="window" class="border rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" onchange="this.form.submit()">
                            @foreach([7,14,30,60,90,180] as $w)
                                <option value="{{ $w }}" {{ $w == $window ? 'selected' : '' }}>{{ $w }} days</option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <!-- Summary cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6 md:gap-8 xl:gap-10 mb-6">
                    <div class="rounded-lg border border-gray-200 bg-white/80 bg-gradient-card backdrop-blur-sm shadow-sm p-5">
                        <div class="text-sm text-gray-600">Total OUT (last {{ $window }} days)</div>
                        <div class="mt-1 text-2xl font-semibold text-gray-900" aria-live="polite">{{ $totalOut }}</div>
                    </div>
                    <div class="rounded-lg border border-gray-200 bg-white/80 bg-gradient-card backdrop-blur-sm shadow-sm p-5">
                        <div class="text-sm text-gray-600">Categories with activity</div>
                        <div class="mt-1 text-2xl font-semibold text-gray-900">{{ $byCategory->count() }}</div>
                    </div>
                    <div class="rounded-lg border border-gray-200 bg-white/80 bg-gradient-card backdrop-blur-sm shadow-sm p-5">
                        <div class="text-sm text-gray-600">Average OUT / day</div>
                        <div class="mt-1 text-2xl font-semibold text-gray-900">{{ round($totalOut / max($window,1), 1) }}</div>
                    </div>
                </div>

                <!-- Visualization -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-900 mb-3">Out-quantity by Category</h2>
                    <canvas id="publicReportBarChart" role="img" aria-label="Bar chart showing total out quantities by category"></canvas>
                </div>

                <!-- Breakdown table (no inventory-level details) -->
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 mb-3">Category Breakdown</h2>
                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Category</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Total OUT</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($byCategory as $row)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-900">{{ $row->category_name }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ (int)$row->total_out }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-4 py-3 text-sm text-gray-500">No activity recorded in the selected window.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
      window.__publicByCategory = {
        labels: @json($chart['labels']),
        series: @json($chart['series'])
      };
    </script>
    @endpush
</x-layouts.public>