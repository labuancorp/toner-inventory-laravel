<?php

namespace App\Notifications;

use App\Models\Item;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ReorderAlert extends Notification
{
    use Queueable;

    public function __construct(public Item $item)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Reorder Alert: '.$this->item->name)
            ->line('Item "'.$this->item->name.'" (SKU: '.$this->item->sku.') has reached the reorder threshold.')
            ->line('Current quantity: '.$this->item->quantity.' • Reorder level: '.$this->item->reorder_level)
            ->action('View Item', url(route('items.show', $this->item)))
            ->line('Please create a purchase order or restock as needed.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'item_id' => $this->item->id,
            'name' => $this->item->name,
            'sku' => $this->item->sku,
            'quantity' => $this->item->quantity,
            'reorder_level' => $this->item->reorder_level,
            'avg_daily_out_30' => $this->item->averageDailyOut(30),
            'days_of_cover' => $this->item->daysOfCover(30),
            'recommended_reorder' => $this->item->recommendedReorderQty(14, 1.2, 30),
        ];
    }
}