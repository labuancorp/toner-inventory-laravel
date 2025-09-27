<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schedule;
use App\Models\User;
use App\Models\Printer;
use App\Notifications\PrinterMaintenanceDue;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Notify admins daily of due printer maintenance
Artisan::command('printers:notify-due', function () {
    $duePrinters = Printer::all()->filter(fn(Printer $p) => $p->is_due);
    if ($duePrinters->isEmpty()) {
        $this->info('No printers currently due.');
        return;
    }
    $admins = User::where('role', 'admin')->get();
    foreach ($duePrinters as $printer) {
        Notification::send($admins, new PrinterMaintenanceDue($printer));
        $this->info("Notified admins: {$printer->name} ({$printer->serial_number}) due.");
    }
})->purpose('Notify admins of due printers');

Schedule::command('printers:notify-due')
    ->dailyAt('08:00')
    ->withoutOverlapping();
