<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Item;
use App\Models\User;

class AdminNewOrder extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Queue name for this notification.
     */
    public $queue = 'emails';

    /**
     * Number of retry attempts.
     */
    public $tries = 3;

    /**
     * Backoff schedule between retries (seconds).
     */
    public function backoff(): array
    {
        return [60, 300, 600];
    }

    public function __construct(
        public Item $item,
        public int $quantity,
        public ?User $customer = null,
        public ?string $customerName = null,
        public ?string $shippingAddress = null,
        public ?string $notes = null,
    ) {
        $this->onQueue('mail');
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject('New Order Placed');

        // Use Markdown template for easy customization
        $view = 'emails.admin_new_order';
        $data = [
            'item' => $this->item,
            'quantity' => $this->quantity,
            'customer' => $this->customer,
            'customerName' => $this->customerName,
            'shippingAddress' => $this->shippingAddress,
            'notes' => $this->notes,
            'dashboardUrl' => url(route('dashboard')),
        ];

        return $message->markdown($view, $data);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'admin_new_order',
            'item' => [
                'id' => $this->item->id,
                'name' => $this->item->name,
                'sku' => $this->item->sku,
            ],
            'quantity' => $this->quantity,
            'customer' => $this->customer ? [
                'id' => $this->customer->id,
                'name' => $this->customer->name,
                'email' => $this->customer->email,
            ] : null,
            'customer_name' => $this->customerName,
            'shipping_address' => $this->shippingAddress,
            'notes' => $this->notes,
        ];
    }
}