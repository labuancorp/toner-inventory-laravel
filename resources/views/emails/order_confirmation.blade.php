@component('mail::message')
# Order Confirmation

Thanks for your order!

**Item:** {{ $item->name }} (SKU: {{ $item->sku }})

**Quantity:** {{ $quantity }}

@if(!empty($customerName))
**Customer:** {{ $customerName }}
@endif

@if(!empty($shippingAddress))
**Shipping Address:** {{ $shippingAddress }}
@endif

@if(!empty($notes))
**Notes:** {{ $notes }}
@endif

@component('mail::button', ['url' => $manageUrl])
Manage Notification Settings
@endcomponent

If you have any questions, reply to this email.

Thanks,
{{ config('app.name') }}
@endcomponent