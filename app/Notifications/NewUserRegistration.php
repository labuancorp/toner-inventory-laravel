<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewUserRegistration extends Notification
{
    use Queueable;

    public function __construct(public User $user)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New User Registration')
            ->line('A new user has registered:')
            ->line('Name: '.$this->user->name)
            ->line('Email: '.$this->user->email)
            ->action('View Users', url(route('admin.dashboard')));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'name' => $this->user->name,
            'email' => $this->user->email,
            'type' => 'new_registration',
        ];
    }
}