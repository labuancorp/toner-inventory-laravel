<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('items.{itemId}', function ($user, int $itemId) {
    // Allow admins and managers to listen to item channels
    return in_array($user->role ?? 'user', ['admin', 'manager']);
});