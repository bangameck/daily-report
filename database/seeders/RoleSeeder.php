<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

// Import DB facade

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kosongkan tabel sebelum seeding (opsional, hati-hati jika data sudah ada)
        // DB::table('roles')->truncate();

        DB::table('roles')->insert([
            ['role_id' => 1, 'nm_role' => 'admin super', 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 2, 'nm_role' => 'anggota', 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 3, 'nm_role' => 'karu', 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 4, 'nm_role' => 'pengawas', 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 5, 'nm_role' => 'pimpinan', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
