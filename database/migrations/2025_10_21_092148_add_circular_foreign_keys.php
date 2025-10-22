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
        Schema::table('users', function (Blueprint $table) {
                                                           // Beri nama constraint kustom, contoh: 'fk_users_to_regu'
            $table->foreign('regu_id', 'fk_users_regu_id') // <-- TAMBAHKAN NAMA DI SINI
                ->references('id_regu')
                ->on('regu')
                ->onDelete('set null');
        });

        Schema::table('regu', function (Blueprint $table) {
                                                       // Beri nama constraint kustom, contoh: 'fk_regu_to_users'
            $table->foreign('karu', 'fk_regu_karu_id') // <-- TAMBAHKAN NAMA DI SINI
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Gunakan nama kustom yang sama untuk drop
            $table->dropForeign('fk_users_regu_id');
        });

        Schema::table('regu', function (Blueprint $table) {
            // Gunakan nama kustom yang sama untuk drop
            $table->dropForeign('fk_regu_karu_id');
        });
    }
};
