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
        Schema::create('users', function (Blueprint $table) {
            // Field bawaan Laravel/Breeze (dimodifikasi sedikit)
            $table->id();
            $table->string('nama');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            // Field custom dari penjelasanmu
            $table->string('username')->unique();
            $table->string('no_hp', 20)->nullable();
            $table->string('nik', 16)->unique();
            $table->string('nip', 18)->unique()->nullable();
            $table->string('pendidikan')->nullable();
            $table->text('alamat')->nullable();
            $table->string('t_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->enum('jk', ['L', 'P'])->nullable();

                                                                           // Foreign Key untuk Role (menggantikan 'level')
            $table->foreignId('role_id')->constrained('roles', 'role_id'); // Pastikan tabel roles & kolom PK benar

                                                                                      // Foreign Key untuk Regu (menggantikan 'regu')
            $table->foreignId('regu_id')->nullable()->constrained('regu', 'id_regu'); // Pastikan tabel regu & kolom PK benar
                                                                                      // Pastikan tabel regu & kolom PK benar
                                                                                      // ->onDelete('set null'); // Opsional

            $table->string('gol_drh', 3)->nullable();
            $table->string('f_ust')->nullable(); // Path image profile
            $table->string('otp')->nullable();
            $table->timestamp('batas_waktu')->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('member')->nullable();

            // Timestamps + Soft Deletes
            $table->timestamps();
            $table->softDeletes();
        });

        // Tabel bawaan Laravel/Breeze lainnya
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
