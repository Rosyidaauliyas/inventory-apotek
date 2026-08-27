<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk menambah kolom Phone dan Avatar.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Memasang kolom phone tepat di bawah email
            $table->string('phone')->nullable()->after('email');
            
            // Memasang kolom avatar tepat di bawah phone yang baru dibuat
            $table->string('avatar')->nullable()->after('phone');
        });
    }

    /**
     * Batalkan migrasi (Rollback).
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menghapus kembali kolom jika migrasi dibatalkan
            $table->dropColumn(['phone', 'avatar']);
        });
    }
};