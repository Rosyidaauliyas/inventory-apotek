<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterObat extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_obat', 
        'nama_obat', 
        'golongan', 
        'satuan', 
        'stok_minimal'
    ];

    public function batches(): HasMany
    {
        return $this->hasMany(Obat::class, 'master_obat_id');
    }

    /**
     * PHP 8.4 PROPERTY HOOKS: Agregasi Stok AMAN
     * Hanya menjumlahkan stok yang > 0 DAN belum kadaluarsa.
     */
    public int $total_stok {
        get => $this->batches()
                    ->where('stok', '>', 0)
                    ->whereDate('tgl_kadaluarsa', '>', now()) // Filter pengaman
                    ->sum('stok');
    }

    /**
     * PROPERTY HOOK: Status Kritis
     * Mengecek ambang batas berdasarkan stok yang aman saja.
     */
    public bool $is_kritis {
        get => $this->total_stok < ($this->stok_minimal ?? 10);
    }

    /**
     * PROPERTY HOOK: Label Identitas untuk Dropdown
     * Menampilkan informasi stok valid agar user tidak bingung.
     */
    public string $full_label {
        get => "[{$this->kode_obat}] {$this->nama_obat} (Tersedia: {$this->total_stok} {$this->satuan})";
    }
}