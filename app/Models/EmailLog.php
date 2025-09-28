<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'to_email',
        'subject',
        'status',
        'provider_message_id',
        'notification_type',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];
}