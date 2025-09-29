<li class="win11-nav-item">
    @php
        $unreadCount = optional(auth()->user())->unreadNotifications()->count();
    @endphp
    <button class="win11-nav-link win11-w-full win11-text-start win11-flex win11-justify-between win11-items-center" type="button" onclick="toggleNotifications()" aria-controls="notifCollapse" aria-expanded="false" aria-label="Toggle notifications">
        <span class="win11-nav-link-text">Notifications</span>
        @if($unreadCount > 0)
        <span class="win11-badge win11-badge-danger" id="notifBadge" aria-label="Unread notifications">{{ $unreadCount }}</span>
        @endif
    </button>
    <div id="notifCollapse" class="win11-hidden" aria-labelledby="notifCollapse">
        <ul class="win11-list-none win11-pl-3 win11-pr-2 win11-py-2 win11-mb-0">
            <li class="win11-flex win11-justify-end win11-mb-2">
                <button type="button" class="win11-button win11-button-secondary win11-button-sm" id="notifCloseBtn" aria-label="Close notifications">Close</button>
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
                    <a class="win11-dropdown-item win11-px-0 win11-py-2"
                       href="{{ $link }}"
                       data-order-id="{{ $orderId }}"
                       data-order-number="{{ $orderNumber }}"
                       data-customer="{{ $customer }}"
                       data-items-count="{{ $itemsCount }}"
                       data-total="{{ $totalAmount }}"
                       data-message="{{ $message }}"
                       data-created-at="{{ $n->created_at->diffForHumans() }}">
                        <strong class="win11-block win11-text-truncate" style="max-width: 240px;">
                            {{ $hasOrder ? ($orderNumber ? 'Incoming Order ' . $orderNumber : 'Incoming Order #' . $orderId) : $message }}
                        </strong>
                        @if($hasOrder && $summary)
                            <div class="win11-text-sm win11-text-secondary win11-text-truncate" style="max-width: 240px;">{{ $summary }}</div>
                        @else
                            <div class="win11-text-sm win11-text-secondary">{{ $n->created_at->diffForHumans() }}</div>
                        @endif
                    </a>
                </li>
            @empty
                <li><span class="win11-dropdown-item win11-text-secondary win11-px-0 win11-py-2">No unread notifications</span></li>
            @endforelse
            <li class="win11-mt-2">
                <form method="POST" action="{{ route('notifications.readAll') }}" class="">
                    @csrf
                    <button type="submit" class="win11-button win11-button-secondary win11-button-sm win11-w-full">Mark all as read</button>
                </form>
            </li>
        </ul>
    </div>
</li>