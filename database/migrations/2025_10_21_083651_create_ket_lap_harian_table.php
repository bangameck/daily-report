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
        Schema::create('ket_lap_harian', function (Blueprint $table) {
            $table->id('id_ket_lap');                                                                               // Primary key
            $table->foreignId('lap_harian_id')->unique()->constrained('lap_harian', 'id_lap')->onDelete('cascade'); // Foreign key ke lap_harian (unik: one-to-one), hapus jika laporan dihapus
            $table->foreignId('pengawas_id')->nullable()->constrained('users');                                     // Foreign key ke tabel users (pengawas), boleh null
                                                                                                                    // ->onDelete('set null'); // Opsional: Jika user pengawas dihapus, set null di sini
            $table->text('ket_reject')->nullable();                                                                 // Keterangan jika ditolak (boleh null)
            $table->timestamps();                                                                                   // created_at, updated_at
            $table->softDeletes();                                                                                  // deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ket_lap_harian');
    }
};
