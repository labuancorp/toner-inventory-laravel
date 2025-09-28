<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function get(string $key, $default = null)
    {
        if (! Schema::hasTable('settings')) {
            return $default;
        }
        $record = static::query()->where('key', $key)->first();
        return $record ? $record->value : $default;
    }

    public static function set(string $key, $value): void
    {
        if (! Schema::hasTable('settings')) {
            // Table missing; skip to avoid errors. Ensure migrations are run.
            return;
        }
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}