<li class="nav-item">
    @php
        $unreadCount = optional(auth()->user())->unreadNotifications()->count();
    @endphp
    <button class="nav-link w-100 text-start d-flex justify-content-between align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#notifCollapse" aria-controls="notifCollapse" aria-expanded="false" aria-label="Toggle notifications">
        <span class="nav-link-text">Notifications</span>
        @if($unreadCount > 0)
        <span class="badge rounded-pill bg-danger" id="notifBadge" aria-label="Unread notifications">{{ $unreadCount }}</span>
        @endif
    </button>
    <div id="notifCollapse" class="collapse" aria-labelledby="notifCollapse" data-persist-ms="12000" data-autohide="false">
        <ul class="list-unstyled ps-3 pe-2 py-2 mb-0">
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
                    <a class="dropdown-item px-0 py-2"
                       href="{{ $link }}"
                       data-order-id="{{ $orderId }}"
                       data-order-number="{{ $orderNumber }}"
                       data-customer="{{ $customer }}"
                       data-items-count="{{ $itemsCount }}"
                       data-total="{{ $totalAmount }}"
                       data-message="{{ $message }}"
                       data-created-at="{{ $n->created_at->diffForHumans() }}">
                        <strong class="d-block text-truncate" style="max-width: 240px;">
                            {{ $hasOrder ? ($orderNumber ? 'Incoming Order ' . $orderNumber : 'Incoming Order #' . $orderId) : $message }}
                        </strong>
                        @if($hasOrder && $summary)
                            <div class="small text-secondary text-truncate" style="max-width: 240px;">{{ $summary }}</div>
                        @else
                            <div class="small text-secondary">{{ $n->created_at->diffForHumans() }}</div>
                        @endif
                    </a>
                </li>
            @empty
                <li><span class="dropdown-item text-secondary px-0 py-2">No unread notifications</span></li>
            @endforelse
            <li class="mt-2">
                <form method="POST" action="{{ route('notifications.readAll') }}" class="">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-secondary w-100">Mark all as read</button>
                </form>
            </li>
        </ul>
    </div>
</li>