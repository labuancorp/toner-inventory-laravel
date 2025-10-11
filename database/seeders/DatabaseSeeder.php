<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use App\Models\Printer;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ensure demo admin exists
        $this->call(DemoAdminSeeder::class);
        // Admin user
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'password' => Hash::make('password'), 'role' => 'admin']
        );

        // Base categories
        $categories = [
            ['name' => 'Toners', 'slug' => 'toners', 'description' => 'Printer toner cartridges'],
            ['name' => 'CD-ROMs', 'slug' => 'cd-roms', 'description' => 'Optical media discs'],
            ['name' => 'Office Supplies', 'slug' => 'office-supplies', 'description' => 'General supplies'],
        ];

        foreach ($categories as $c) {
            Category::updateOrCreate(['slug' => $c['slug']], $c);
        }

        // Sample items
        $items = [
            ['name' => 'HP 12A Black Toner', 'sku' => 'HP-12A', 'quantity' => 8, 'reorder_level' => 5, 'location' => 'Shelf A1', 'notes' => 'For HP LaserJet 1010', 'category_slug' => 'toners'],
            ['name' => 'Canon 052H Toner', 'sku' => 'CAN-052H', 'quantity' => 3, 'reorder_level' => 4, 'location' => 'Shelf A2', 'notes' => 'For Canon MF429dw', 'category_slug' => 'toners'],
            ['name' => 'Verbatim CD-R 700MB', 'sku' => 'VB-CDR-700', 'quantity' => 100, 'reorder_level' => 50, 'location' => 'Bin B1', 'notes' => null, 'category_slug' => 'cd-roms'],
            ['name' => 'Staples Box', 'sku' => 'STP-BOX', 'quantity' => 20, 'reorder_level' => 10, 'location' => 'Cabinet C1', 'notes' => null, 'category_slug' => 'office-supplies'],
            ['name' => 'A4 Paper Pack', 'sku' => 'A4-PAPER', 'quantity' => 5, 'reorder_level' => 8, 'location' => 'Cabinet C2', 'notes' => '80gsm', 'category_slug' => 'office-supplies'],
        ];

        foreach ($items as $data) {
            $category = Category::where('slug', $data['category_slug'])->first();
            if (!$category) {
                continue;
            }
            Item::updateOrCreate(
                ['sku' => $data['sku']],
                [
                    'category_id' => $category->id,
                    'name' => $data['name'],
                    'quantity' => $data['quantity'],
                    'reorder_level' => $data['reorder_level'],
                    'location' => $data['location'],
                    'notes' => $data['notes'],
                    'barcode_type' => 'CODE_128',
                ]
            );
        }

        // Sample printers for verification
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
