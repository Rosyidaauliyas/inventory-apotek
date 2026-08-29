<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Obat extends Model
{
    use HasFactory;

    // Izinkan semua kolom diisi, tapi tetap aman karena primary key dilindungi Laravel
    protected $guarded = ['id'];

    /**
     * RELASI: Menghubungkan Batch ke Master Obat
     * Satu baris stok (batch) ini adalah milik satu Master Obat.
     */
    public function masterObat(): BelongsTo
    {
        return $this->belongsTo(MasterObat::class, 'master_obat_id');
    }

    /**
     * Label stok tambahan, default kosong.
     */
    public string $stok_label = "";

    /**
     * Menggantikan Accessor
     * Langsung menentukan status batch secara real-time.
     */
    public function getStatusAttribute(): string
    {
        $kadaluarsa = $this->tgl_kadaluarsa ? Carbon::parse($this->tgl_kadaluarsa) : null;
        $hariIni = now();

        return match(true) {
            // 1. Cek Stok Habis 
            $this->stok <= 0 => 'HABIS',

            // 2. Cek Kadaluarsa (Kritikal secara medis)
            $kadaluarsa?->isBefore($hariIni) => 'KADALUARSA',
            
            // 3. Cek Hampir Kadaluarsa (Peringatan 2 bulan sebelum)
            $kadaluarsa?->isBetween($hariIni, $hariIni->copy()->addMonths(2)) => 'HAMPIR EXP',

            // 4. Cek Stok Hampir Habis (Sesuai parameter stok minimal di Master)
            $this->stok < ($this->masterObat->stok_minimal ?? 10) => 'HAMPIR HABIS',

            // 5. Kondisi Aman
            default => 'TERSEDIA',
        };
    }

    /**
     * Format Harga
     * Biar di View tinggal panggil $obat->harga_rp
     */
    public function getHargaRpAttribute(): string
    {
        return "Rp " . number_format($this->harga, 0, ',', '.');
    }
}