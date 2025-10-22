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
        Schema::create('kat_lap_harian', function (Blueprint $table) {
            $table->id('id_kat');          // Primary key 'id_kat'
            $table->string('nm_kategori'); // Nama kategori
            $table->timestamps();          // created_at, updated_at
            $table->softDeletes();         // deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kat_lap_harian');
    }
};
