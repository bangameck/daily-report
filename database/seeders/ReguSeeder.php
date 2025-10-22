<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

// Import DB facade

class ReguSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data Regu
        $reguData = [
            ['nm_regu' => 'Regu 1', 'karu' => null, 'created_at' => now(), 'updated_at' => now()],
            ['nm_regu' => 'Regu 2', 'karu' => null, 'created_at' => now(), 'updated_at' => now()],
            ['nm_regu' => 'Regu 3', 'karu' => null, 'created_at' => now(), 'updated_at' => now()],
        ];

        // Kosongkan tabel sebelum seeding (opsional)
        // DB::table('regu')->truncate(); // Hati-hati jika data sudah ada

        // Masukkan data ke tabel
        DB::table('regu')->insert($reguData);
    }
}
