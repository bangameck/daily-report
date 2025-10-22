<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lap_harian', function (Blueprint $table) {
            $table->id('id_lap');                                                                           // Primary key 'id_lap'
            $table->string('no_lap')->unique();                                                             // Nomor Laporan unik (pembuatan format di logic aplikasi)
            $table->date('tgl_lap');                                                                        // Tanggal laporan
            $table->time('jam_s');                                                                          // Jam mulai
            $table->time('jam_f');                                                                          // Jam selesai
            $table->foreignId('user_id')->constrained('users');                                             // Foreign key ke tabel users (pengganti usr_lap)
            $table->foreignId('regu_id')->nullable()->constrained('regu', 'id_regu')->onDelete('set null'); // Foreign key ke tabel regu (nullable, jika user pindah regu, laporan tetap tercatat di regu lama)
            $table->foreignId('id_kat')->constrained('kat_lap_harian', 'id_kat');                           // Foreign key ke tabel kategori
            $table->string('laporan');                                                                      // Judul laporan
            $table->text('ket_lap')->nullable();                                                            // Deskripsi laporan (boleh null)
            $table->enum('st_lap', ['pending', 'verified', 'rejected'])->default('pending');                // Status laporan
            $table->timestamps();                                                                           // created_at, updated_at
            $table->softDeletes();                                                                          // deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lap_harian');
    }
};
