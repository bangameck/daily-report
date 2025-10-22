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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();                                                                      // Primary key (bisa pakai 'profile_id' jika mau)
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade'); // Foreign key ke users, unik (one-to-one), hapus profile jika user dihapus
            $table->date('tmt')->nullable();                                                   // Terhitung Mulai Tanggal (hanya tanggal)
            $table->string('fb')->nullable();                                                  // Link Facebook
            $table->string('tw')->nullable();                                                  // Link Twitter/X
            $table->string('ig')->nullable();                                                  // Link Instagram
            $table->timestamps();                                                              // created_at, updated_at
            $table->softDeletes();                                                             // deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
