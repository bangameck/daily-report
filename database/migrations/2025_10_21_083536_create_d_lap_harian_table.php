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
        Schema::create('d_lap_harian', function (Blueprint $table) {
            $table->id('id_d_lap');                                                                       // Primary key 'id_d_lap'
            $table->foreignId('lap_harian_id')->constrained('lap_harian', 'id_lap')->onDelete('cascade'); // Foreign key ke lap_harian (hapus dokumentasi jika laporan dihapus)
            $table->string('n_d_lap');                                                                    // Nama file/path dokumentasi
            $table->string('x_lap', 10)->nullable();                                                      // Ekstensi file (max 10 char), boleh null
            $table->timestamps();                                                                         // created_at, updated_at
            $table->softDeletes();                                                                        // deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('d_lap_harian');
    }
};
