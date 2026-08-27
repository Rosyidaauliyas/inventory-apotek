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
        Schema::create('akurasi_stoks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('obat_id')->constrained('obats')->onDelete('cascade');
            $table->integer('stok_sistem'); // Stok yang tercatat di web
            $table->integer('stok_fisik');  // Stok yang dihitung manual di rak
            $table->integer('selisih');  // Hasil pengurangan sistem - fisik
            $table->date('tgl_pengecekan');
            $table->string('petugas');      
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akurasi_stoks');
    }
};
