<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TwoFactorCode extends Notification
{
    use Queueable;

    public function __construct(public string $code)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Two-Factor Authentication Code')
            ->line('Use the code below to complete your sign-in:')
            ->line('Code: '.$this->code)
            ->line('This code expires in 10 minutes.')
            ->line('If you did not attempt to sign in, you can ignore this email.');
    }
}