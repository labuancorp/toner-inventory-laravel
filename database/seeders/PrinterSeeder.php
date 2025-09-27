<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Printer;

class PrinterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $printers = [
            [
                'name' => 'HP LaserJet Pro M404n',
                'model' => 'M404n',
                'serial_number' => 'HP-M404N-0001',
                'location' => 'IT Room',
                'last_service_at' => now()->subMonths(7)->toDateString(),
                'maintenance_interval_months' => 6,
                'notes' => 'Primary office mono printer',
            ],
            [
                'name' => 'Brother HL-L2350DW',
                'model' => 'HL-L2350DW',
                'serial_number' => 'BR-2350-0007',
                'location' => 'Front Desk',
                'last_service_at' => now()->subMonths(2)->toDateString(),
                'maintenance_interval_months' => 6,
                'notes' => 'Wireless duplex mono printer',
            ],
        ];

        foreach ($printers as $p) {
            Printer::updateOrCreate(
                ['serial_number' => $p['serial_number']],
                $p
            );
        }
    }
}