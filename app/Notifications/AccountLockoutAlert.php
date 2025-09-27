<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AccountLockoutAlert extends Notification
{
    use Queueable;

    public function __construct(public string $email, public string $ip)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Account Lockout Alert')
            ->line('A login lockout occurred after 5 failed attempts.')
            ->line('Email: '.$this->email)
            ->line('IP Address: '.$this->ip)
            ->line('If this was unexpected, consider investigating recent activity.')
            ->action('View Users', url(route('dashboard')));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'email' => $this->email,
            'ip' => $this->ip,
            'type' => 'lockout',
        ];
    }
}