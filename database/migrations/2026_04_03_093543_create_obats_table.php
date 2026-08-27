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
        Schema::create('obats', function (Blueprint $table) {
            $table->id();

            // 1. Link ke Master Obat (Sesuai revisi Dosen)
            // Ini yang menghubungkan banyak batch ke satu identitas obat yang sama
            $table->foreignId('master_obat_id')
                  ->constrained('master_obats')
                  ->onDelete('cascade');

            // 2. Data Spesifik Per Batch (Inilah kunci FIFO)
            $table->string('batch'); 
            $table->integer('stok')->default(0);
            $table->integer('harga')->nullable(); 
            $table->date('tgl_masuk'); 
            $table->date('tgl_kadaluarsa');
            $table->string('supplier')->nullable();

            // 3. Nama obat tetap ada (opsional) atau bisa dihapus. 
            // Saran: biarkan dulu untuk mempermudah transisi data lama.
            $table->string('nama_obat')->nullable(); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obats');
    }
};