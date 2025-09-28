<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Item;
use App\Models\StockMovement;

class OrderConfirmation extends Notification implements ShouldQueue
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
        public ?string $customerName = null,
        public ?string $shippingAddress = null,
        public ?string $notes = null,
    ) {
        // Queue configuration (queue name can be customized per channel)
        $this->onQueue('mail');
    }

    public function via(object $notifiable): array
    {
        // Respect user preferences for order emails
        $channels = [];
        $enabled = (bool) (data_get($notifiable, 'pref_order_emails_enabled', true));
        if ($enabled) {
            $channels[] = 'mail';
            $channels[] = 'database';
        }
        return $channels;
    }

    public function toMail(object $notifiable): MailMessage
    {
        $format = (string) (data_get($notifiable, 'pref_email_format', 'html') ?: 'html');
        $message = (new MailMessage)
            ->subject('Order Confirmation');

        // Use Markdown templates for easy customization
        $view = 'emails.order_confirmation';
        $data = [
            'item' => $this->item,
            'quantity' => $this->quantity,
            'customerName' => $this->customerName,
            'shippingAddress' => $this->shippingAddress,
            'notes' => $this->notes,
            'manageUrl' => url(route('profile.edit')),
            'format' => $format,
        ];

        return $message->markdown($view, $data);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'order_confirmation',
            'item' => [
                'id' => $this->item->id,
                'name' => $this->item->name,
                'sku' => $this->item->sku,
            ],
            'quantity' => $this->quantity,
            'customer_name' => $this->customerName,
            'shipping_address' => $this->shippingAddress,
            'notes' => $this->notes,
        ];
    }
}