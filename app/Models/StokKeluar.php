<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokKeluar extends Model
{
    // Tambahkan baris 
    protected $fillable = [
        'obat_id', 
        'jumlah_keluar', 
        'tgl_keluar', 
        'keterangan'
    ];

    // Relasi ke tabel obat
    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }
}