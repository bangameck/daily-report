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
        Schema::create('regu', function (Blueprint $table) { // Menggunakan nama tabel 'regu'
            $table->id('id_regu');                               // Primary key 'id_regu'
            $table->string('nm_regu');                           // Nama regu
            $table->unsignedBigInteger('karu')->nullable();      // Opsional: Jika user karu dihapus, set karu di regu jadi null
            $table->string('f_regu')->nullable();                // Path image regu
            $table->timestamps();                                // created_at dan updated_at
            $table->softDeletes();                               // deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regu');
    }
};
