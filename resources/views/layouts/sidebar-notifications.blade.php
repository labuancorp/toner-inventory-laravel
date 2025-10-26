<li>
    @php
        $unreadCount = optional(auth()->user())->unreadNotifications()->count();
    @endphp
    <button class="flex items-center justify-between gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 text-surface-600 hover:bg-surface-100 hover:text-surface-900 w-full text-left" type="button" onclick="toggleNotifications()" aria-controls="notifCollapse" aria-expanded="false" aria-label="Toggle notifications">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
            </svg>
            <span class="flex-1">Notifications</span>
        </div>
        @if($unreadCount > 0)
        <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-danger-500 rounded-full" id="notifBadge" aria-label="Unread notifications">{{ $unreadCount }}</span>
        @endif
    </button>
    <div id="notifCollapse" class="hidden" aria-labelledby="notifCollapse">
        <ul class="list-none pl-3 pr-2 py-2 mb-0">
            <li class="flex justify-end mb-2">
                <button type="button" class="px-3 py-1 text-xs font-medium text-surface-600 bg-surface-100 border border-surface-300 rounded-md hover:bg-surface-200 transition-colors duration-200" id="notifCloseBtn" aria-label="Close notifications">Close</button>
            </li>
            @php
                $unread = optional(auth()->user())->unreadNotifications()->take(5)->get();
            @endphp
            @forelse($unread as $n)
                @php
                    $orderId = $n->data['order_id'] ?? ($n->data['order']['id'] ?? null);
                    $orderNumber = $n->data['order_number'] ?? ($n->data['order']['number'] ?? null);
                    $customer = $n->data['customer_name'] ?? ($n->data['order']['customer_name'] ?? null);
                    $itemsCount = $n->data['items_count'] ?? ($n->data['order']['items_count'] ?? null);
                    $totalAmount = $n->data['total_amount'] ?? ($n->data['order']['total_amount'] ?? null);
                    $message = $n->data['message'] ?? 'Notification';
                    $hasOrder = $orderId || $orderNumber;
                    $link = $hasOrder ? '#' : (isset($n->data['item_id']) ? route('items.show', ['item' => $n->data['item_id']]) : '#');
                    $summaryParts = [];
                    if ($hasOrder) {
                        $summaryParts[] = 'Order ' . ($orderNumber ? $orderNumber : ('#' . $orderId));
                    }
                    if ($customer) $summaryParts[] = $customer;
                    if ($itemsCount) $summaryParts[] = $itemsCount . ' items';
                    if ($totalAmount) $summaryParts[] = 'Total ' . $totalAmount;
                    $summary = implode(' • ', $summaryParts);
                @endphp
                <li>
                    <a class="block px-0 py-2 text-surface-700 hover:bg-surface-50 rounded-md transition-colors duration-200"
                       href="{{ $link }}"
                       data-order-id="{{ $orderId }}"
                       data-order-number="{{ $orderNumber }}"
                       data-customer="{{ $customer }}"
                       data-items-count="{{ $itemsCount }}"
                       data-total="{{ $totalAmount }}"
                       data-message="{{ $message }}"
                       data-created-at="{{ $n->created_at->diffForHumans() }}">
                        <strong class="block truncate font-semibold text-sm" style="max-width: 240px;">
                            {{ $hasOrder ? ($orderNumber ? 'Incoming Order ' . $orderNumber : 'Incoming Order #' . $orderId) : $message }}
                        </strong>
                        @if($hasOrder && $summary)
                            <div class="text-xs text-surface-500 truncate" style="max-width: 240px;">{{ $summary }}</div>
                        @else
                            <div class="text-xs text-surface-500">{{ $n->created_at->diffForHumans() }}</div>
                        @endif
                    </a>
                </li>
            @empty
                <li><span class="block text-surface-500 px-0 py-2 text-sm">No unread notifications</span></li>
            @endforelse
            <li class="mt-2">
                <form method="POST" action="{{ route('notifications.readAll') }}" class="">
                    @csrf
                    <button type="submit" class="w-full px-3 py-1 text-xs font-medium text-surface-600 bg-surface-100 border border-surface-300 rounded-md hover:bg-surface-200 transition-colors duration-200">Mark all as read</button>
                </form>
            </li>
        </ul>
    </div>
</li>