<?php

namespace App\Events;

use App\Models\Item;
use App\Models\StockMovement;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StockAdjusted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Item $item;
    public StockMovement $movement;

    public function __construct(Item $item, StockMovement $movement)
    {
        $this->item = $item->withoutRelations();
        $this->movement = $movement->withoutRelations();
    }

    public function broadcastOn(): array
    {
        return [new PrivateChannel('items.'.$this->item->id)];
    }

    public function broadcastAs(): string
    {
        return 'StockAdjusted';
    }

    public function broadcastWith(): array
    {
        return [
            'item_id' => $this->item->id,
            'sku' => $this->item->sku,
            'type' => $this->movement->type,
            'quantity' => (int) $this->movement->quantity,
            'new_quantity' => (int) $this->item->quantity,
            'reason' => $this->movement->reason,
            'user_id' => $this->movement->user_id,
            'movement_id' => $this->movement->id,
            'timestamp' => optional($this->movement->created_at)->toIso8601String(),
        ];
    }
}