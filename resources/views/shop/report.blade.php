<x-layouts.public>
<div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 mb-4">
        <h1 class="text-xl font-semibold">My Usage Report</h1>
        <a href="{{ route('shop.report.export', request()->query()) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700 w-full sm:w-auto justify-center">
            <i class="ti ti-download" aria-hidden="true"></i>
            <span>Export CSV</span>
        </a>
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('shop.report') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6">
        <div>
            <label for="days" class="block text-xs sm:text-sm font-medium text-gray-700">Period (days)</label>
            <input type="number" min="7" max="180" id="days" name="days" value="{{ $periodDays }}" class="mt-1 block w-full rounded border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" />
        </div>
        <div>
            <label for="group" class="block text-xs sm:text-sm font-medium text-gray-700">Group by</label>
            <select id="group" name="group" class="mt-1 block w-full rounded border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="daily" @selected($group==='daily')>Daily</option>
                <option value="weekly" @selected($group==='weekly')>Weekly</option>
                <option value="monthly" @selected($group==='monthly')>Monthly</option>
            </select>
        </div>
        <div class="sm:col-span-2 lg:col-span-2">
            <label for="category_id" class="block text-xs sm:text-sm font-medium text-gray-700">Toner Type (Category)</label>
            <select id="category_id" name="category_id" class="mt-1 block w-full rounded border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">All</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected($categoryId===$cat->id)>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="lg:col-span-4 flex justify-end">
            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded bg-gray-800 text-white hover:bg-gray-900 w-full sm:w-auto justify-center">
                <i class="ti ti-filter" aria-hidden="true"></i>
                <span>Apply Filters</span>
            </button>
        </div>
    </form>

    <!-- Summary & Chart (span to max) -->
    <div class="grid grid-cols-1 gap-6 mb-6">
        <div class="rounded-lg border border-gray-200 shadow-sm p-3 sm:p-4 w-full">
            <div class="text-center">
                <h2 class="text-lg font-medium">Summary</h2>
                <p class="text-sm text-gray-600">Total toner used in selected period</p>
                <div class="mt-2 text-3xl font-semibold">{{ $totalUsage }}</div>
            </div>
        </div>
        <div class="rounded-lg border border-gray-200 shadow-sm p-3 sm:p-4 w-full">
            <div class="text-center mb-2">
                <h2 class="text-lg font-medium">Usage Over Time</h2>
                <span class="text-sm text-gray-600">{{ ucfirst($group) }} totals</span>
            </div>
            <div class="relative w-full h-56 sm:h-72 md:h-80 lg:h-[28rem]">
                <canvas id="shopPersonalReportChart" class="absolute inset-0 w-full h-full"></canvas>
            </div>
        </div>
    </div>

    <!-- Current Stock Levels & Low Stock Indicators (full width) -->
    <div class="grid grid-cols-1 gap-6 mb-6">
        <div class="rounded-lg border border-gray-200 shadow-sm p-3 sm:p-4 w-full">
            <div class="text-center mb-2">
                <h2 class="text-lg font-medium">Current Stock Levels</h2>
                <span class="text-sm text-gray-600">Filtered by Toner Type</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-xs sm:text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-[10px] sm:text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                            <th class="px-4 py-2 text-left text-[10px] sm:text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-4 py-2 text-left text-[10px] sm:text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                            <th class="px-4 py-2 text-left text-[10px] sm:text-xs font-medium text-gray-500 uppercase tracking-wider">Reorder Level</th>
                            <th class="px-4 py-2 text-left text-[10px] sm:text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-xs sm:text-sm">
                        @foreach($items as $it)
                        @php $low = $it->quantity <= $it->reorder_level; @endphp
                        <tr class="{{ $low ? 'bg-red-50' : '' }}">
                            <td class="px-4 py-2 break-words">{{ $it->name }}</td>
                            <td class="px-4 py-2 break-words">{{ optional($it->category)->name }}</td>
                            <td class="px-4 py-2">{{ $it->quantity }}</td>
                            <td class="px-4 py-2">{{ $it->reorder_level }}</td>
                            <td class="px-4 py-2">
                                @if($low)
                                    <span class="inline-flex items-center gap-2 px-2 py-1 rounded bg-red-100 text-red-700 text-xs">
                                        <i class="ti ti-alert-triangle" aria-hidden="true"></i>
                                        Low Stock
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 px-2 py-1 rounded bg-green-100 text-green-700 text-xs">
                                        <i class="ti ti-check" aria-hidden="true"></i>
                                        OK
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Consumption History (full width) -->
    <div class="grid grid-cols-1 gap-6">
        <div class="rounded-lg border border-gray-200 shadow-sm p-3 sm:p-4 w-full">
            <div class="text-center mb-2">
                <h2 class="text-lg font-medium">Toner Consumption History</h2>
                <span class="text-sm text-gray-600">Your transactions with date/time</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-xs sm:text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-[10px] sm:text-xs font-medium text-gray-500 uppercase tracking-wider">Date/Time</th>
                            <th class="px-4 py-2 text-left text-[10px] sm:text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                            <th class="px-4 py-2 text-left text-[10px] sm:text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-4 py-2 text-left text-[10px] sm:text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-xs sm:text-sm">
                        @forelse($movements as $m)
                        <tr>
                            <td class="px-4 py-2 break-words">{{ $m->created_at->toDayDateTimeString() }}</td>
                            <td class="px-4 py-2 break-words">{{ optional($m->item)->name }}</td>
                            <td class="px-4 py-2 break-words">{{ optional(optional($m->item)->category)->name }}</td>
                            <td class="px-4 py-2">{{ $m->quantity }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td class="px-4 py-2 text-center text-gray-500" colspan="4">No usage found for selected filters.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $movements->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    window.__shopPersonalReportData = @json($chartData);
</script>
@endpush
</x-layouts.public>