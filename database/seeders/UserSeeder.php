<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// Import Hash facade

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Password default untuk semua user
        $defaultPassword = Hash::make('password');

        // Ambil ID Regu
        // Kita asumsikan Regu 1, 2, 3 punya ID 1, 2, 3
        $regu1 = DB::table('regu')->where('nm_regu', 'Regu 1')->value('id_regu');
        $regu2 = DB::table('regu')->where('nm_regu', 'Regu 2')->value('id_regu');
        $regu3 = DB::table('regu')->where('nm_regu', 'Regu 3')->value('id_regu');

        // Ambil ID Role
        $roleAdmin    = 1;
        $roleStaff    = 2;
        $roleKaru     = 3;
        $rolePawas    = 4;
        $rolePimpinan = 5;

        // Data Users
        $users = [
            // 1. Admin Super (Role ID 1)
            [
                'nama'       => 'Admin Super',
                'email'      => 'admin@example.com',
                'password'   => $defaultPassword,
                'username'   => 'adminsuper',
                'nik'        => '1111111111111111', // NIK harus unik
                'nip'        => null,               // NIP harus unik
                'role_id'    => $roleAdmin,
                'regu_id'    => null, // Admin tidak masuk regu
                'no_hp'      => '628111111111',
                'jk'         => 'L',
                'status'     => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 2. Staff/Anggota (Role ID 2) - Regu 1
            [
                'nama'       => 'Staff Anggota 1',
                'email'      => 'staff1@example.com',
                'password'   => $defaultPassword,
                'username'   => 'staff1',
                'nik'        => '2222222222222221',
                'nip'        => null,
                'role_id'    => $roleStaff,
                'regu_id'    => $regu1, // Masuk Regu 1
                'no_hp'      => '628222222221',
                'jk'         => 'L',
                'status'     => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 3. Staff/Anggota (Role ID 2) - Regu 2
            [
                'nama'       => 'Staff Anggota 2',
                'email'      => 'staff2@example.com',
                'password'   => $defaultPassword,
                'username'   => 'staff2',
                'nik'        => '2222222222222222',
                'nip'        => null,
                'role_id'    => $roleStaff,
                'regu_id'    => $regu2, // Masuk Regu 2
                'no_hp'      => '628222222222',
                'jk'         => 'P',
                'status'     => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 4. Karu/Kepala Regu (Role ID 3) - Karu Regu 1
            [
                'nama'       => 'Kepala Regu 1',
                'email'      => 'karu1@example.com',
                'password'   => $defaultPassword,
                'username'   => 'karu1',
                'nik'        => '3333333333333331',
                'nip'        => 'NIP002',
                'role_id'    => $roleKaru,
                'regu_id'    => $regu1, // Masuk Regu 1
                'no_hp'      => '628333333331',
                'jk'         => 'L',
                'status'     => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 5. Karu/Kepala Regu (Role ID 3) - Karu Regu 2
            [
                'nama'       => 'Kepala Regu 2',
                'email'      => 'karu2@example.com',
                'password'   => $defaultPassword,
                'username'   => 'karu2',
                'nik'        => '3333333333333332',
                'nip'        => '00000000000003',
                'role_id'    => $roleKaru,
                'regu_id'    => $regu2, // Masuk Regu 2
                'no_hp'      => '628333333332',
                'jk'         => 'L',
                'status'     => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 6. Pengawas (Role ID 4)
            [
                'nama'       => 'Pengawas Lapangan',
                'email'      => 'pengawas@example.com',
                'password'   => $defaultPassword,
                'username'   => 'pengawas',
                'nik'        => '4444444444444444',
                'nip'        => '00000000000004',
                'role_id'    => $rolePawas,
                'regu_id'    => null, // Pengawas tidak masuk regu
                'no_hp'      => '628444444444',
                'jk'         => 'P',
                'status'     => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 7. Pimpinan (Role ID 5)
            [
                'nama'       => 'Pimpinan UPT',
                'email'      => 'pimpinan@example.com',
                'password'   => $defaultPassword,
                'username'   => 'pimpinan',
                'nik'        => '5555555555555555',
                'nip'        => '0888888888888',
                'role_id'    => $rolePimpinan,
                'regu_id'    => null, // Pimpinan tidak masuk regu
                'no_hp'      => '628555555555',
                'jk'         => 'L',
                'status'     => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Kosongkan tabel sebelum seeding (opsional)
        // DB::table('users')->delete(); // Gunakan delete jika ada foreign key, truncate mungkin gagal

        // Masukkan data ke tabel
        DB::table('users')->insert($users);

        // --- Update 'karu' di tabel 'regu' ---
        // Ambil ID Karu 1 & 2 yang baru dibuat
        $karu1_id = DB::table('users')->where('username', 'karu1')->value('id');
        $karu2_id = DB::table('users')->where('username', 'karu2')->value('id');

        // Update tabel regu
        if ($regu1 && $karu1_id) {
            DB::table('regu')->where('id_regu', $regu1)->update(['karu' => $karu1_id]);
        }
        if ($regu2 && $karu2_id) {
            DB::table('regu')->where('id_regu', $regu2)->update(['karu' => $karu2_id]);
        }
    }
}
