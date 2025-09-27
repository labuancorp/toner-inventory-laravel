<?php

namespace App\Notifications;

use App\Models\Printer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PrinterMaintenanceDue extends Notification
{
    use Queueable;

    public function __construct(public Printer $printer)
    {
    }

    public function via($notifiable): array
    {
        // Send database notification and email if mail is configured
        $channels = ['database'];
        if (config('mail.default')) {
            $channels[] = 'mail';
        }
        return $channels;
    }

    public function toMail($notifiable): MailMessage
    {
        $nextDue = $this->printer->nextDueAt()?->toDateString();
        return (new MailMessage)
            ->subject('Printer Maintenance Due: '.$this->printer->name)
            ->line('A printer is due for maintenance.')
            ->line('Printer: '.$this->printer->name)
            ->line('Model: '.$this->printer->model)
            ->line('Serial: '.$this->printer->serial_number)
            ->line('Location: '.$this->printer->location)
            ->line('Maintenance interval: '.$this->printer->maintenance_interval_months.' months')
            ->line('Next due: '.($nextDue ?? 'Not set'))
            ->action('Open Printers', route('printers.index'))
            ->line('This notification was sent automatically by the system.');
    }

    public function toArray($notifiable): array
    {
        $nextDue = $this->printer->nextDueAt();
        return [
            'type' => 'printer_maintenance_due',
            'printer_id' => $this->printer->id,
            'printer_name' => $this->printer->name,
            'serial_number' => $this->printer->serial_number,
            'location' => $this->printer->location,
            'next_due_at' => $nextDue?->toDateString(),
            'interval_months' => $this->printer->maintenance_interval_months,
        ];
    }
}