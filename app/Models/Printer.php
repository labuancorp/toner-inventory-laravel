<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Printer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'model',
        'serial_number',
        'location',
        'last_service_at',
        'maintenance_interval_months',
        'notes',
        'image_path',
    ];

    protected $casts = [
        'last_service_at' => 'date',
        'maintenance_interval_months' => 'integer',
    ];

    public function nextDueAt(): ?Carbon
    {
        if (!$this->last_service_at) {
            return null;
        }
        return Carbon::parse($this->last_service_at)->addMonths($this->maintenance_interval_months ?? 6);
    }

    public function getIsDueAttribute(): bool
    {
        $next = $this->nextDueAt();
        return $next ? now()->greaterThanOrEqualTo($next) : false;
    }

    public function getDaysUntilDueAttribute(): ?int
    {
        $next = $this->nextDueAt();
        if (!$next) return null;
        return now()->diffInDays($next, false);
    }
}