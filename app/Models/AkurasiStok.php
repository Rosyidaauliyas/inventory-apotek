<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkurasiStok extends Model
{
    use HasFactory;

    // Nambahin ini supaya Laravel gak bingung cari nama tabelnya
    protected $table = 'akurasi_stoks'; 

    protected $fillable = [
        'obat_id', 
        'stok_sistem', 
        'stok_fisik', 
        'selisih', 
        'tgl_pengecekan', 
        'petugas'
    ];

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'obat_id');
    }
}