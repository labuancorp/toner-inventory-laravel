<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'sku',
        'barcode_type',
        'image_path',
        'quantity',
        'reorder_level',
        'location',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'reorder_level' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function movements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    public function getNeedsReorderAttribute(): bool
    {
        return $this->quantity <= $this->reorder_level;
    }

    // Average daily stock out over the last N days (default 30)
    public function averageDailyOut(int $days = 30): float
    {
        $from = now()->subDays($days)->startOfDay();
        $totalOut = $this->movements()
            ->where('type', 'out')
            ->where('created_at', '>=', $from)
            ->sum('quantity');
        $avg = $totalOut / max($days, 1);
        return round($avg, 2);
    }

    // Estimated days of cover = current quantity / avg daily out
    public function daysOfCover(int $daysWindow = 30): float
    {
        $avgOut = $this->averageDailyOut($daysWindow);
        if ($avgOut <= 0) return INF; // No consumption in window => effectively unlimited
        return round($this->quantity / $avgOut, 1);
    }

    // Recommended reorder quantity to reach target cover days with safety buffer
    public function recommendedReorderQty(int $targetCoverDays = 14, float $safetyFactor = 1.2, int $daysWindow = 30): int
    {
        $avgOut = $this->averageDailyOut($daysWindow);
        if ($avgOut <= 0) {
            // Fallback: ensure at least reorder_level
            return max(0, ($this->reorder_level - $this->quantity));
        }
        $targetQty = (int) ceil($avgOut * $targetCoverDays * $safetyFactor);
        $needed = $targetQty - $this->quantity;
        return max(0, $needed);
    }
}