@component('mail::message')
# New Order Placed

A new order has been placed.

**Item:** {{ $item->name }} (SKU: {{ $item->sku }})

**Quantity:** {{ $quantity }}

@if($customer)
**Customer:** {{ $customer->name }} <{{ $customer->email }}>
@endif

@if(!empty($customerName))
**Customer Name:** {{ $customerName }}
@endif

@if(!empty($shippingAddress))
**Shipping Address:** {{ $shippingAddress }}
@endif

@if(!empty($notes))
**Notes:** {{ $notes }}
@endif

@component('mail::button', ['url' => $dashboardUrl])
Open Dashboard
@endcomponent

This is an automated notification.

Thanks,
{{ config('app.name') }}
@endcomponent