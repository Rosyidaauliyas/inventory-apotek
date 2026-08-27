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
    Schema::create('master_obats', function (Blueprint $table) {
        $table->id();
        $table->string('kode_obat')->unique(); // Contoh: ANT-TAB-001
        $table->string('nama_obat');           // Contoh: Amoxicillin 250mg
        $table->string('golongan');            // Contoh: Antibiotik, Analgetik
        $table->string('satuan');              // Contoh: Tablet, Botol, Sirup
        $table->integer('stok_minimal')->default(10); // Alert kalau stok total dikit
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_obats');
    }
};
