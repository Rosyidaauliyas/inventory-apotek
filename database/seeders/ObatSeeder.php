<?php

namespace Database\Seeders;

use App\Models\Obat;
use App\Models\MasterObat;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ObatSeeder extends Seeder
{
    public function run(): void
    {
        $allMaster = MasterObat::all();

        foreach ($allMaster as $index => $master) {

            $jumlahBatch = ($index < 5) ? 2 : 1; 

            for ($i = 1; $i <= $jumlahBatch; $i++) {
                
                // Variabel untuk menampung tanggal (Masuk < Kadaluarsa)
                $tglMasuk = Carbon::now()->subDays(rand(10, 30));

                // Variasi Tanggal Kadaluarsa buat ngetes EWS (Dashboard)
                if ($index == 0 && $i == 1) {
                    // Obat pertama batch 1: Hampir expired (2 bulan lagi) -> Dashboard KUNING
                    $kadaluarsa = Carbon::now()->addMonths(2);
                } elseif ($index == 1) {
                    // Obat kedua: Sudah expired -> Dashboard MERAH
                    // tanggal masuk diset 1 tahun yang lalu
                    $tglMasuk = Carbon::now()->subYears(1);
                    $kadaluarsa = Carbon::now()->subMonths(1);
                } else {
                    // Sisanya aman (1-3 tahun lagi)
                    $kadaluarsa = Carbon::now()->addMonths(rand(12, 36));
                }

                // Mengambil 3 huruf pertama nama obat tanpa spasi
                $inisial = strtoupper(substr(str_replace(' ', '', $master->nama_obat), 0, 3));
                
                // Menggunakan $i sebagai nomor urut batch (001, 002, dst)
                $noBatch = 'BCH-' . $inisial . '-' . sprintf('%03d', $i);

                Obat::create([
                    'master_obat_id' => $master->id,
                    'batch'          => $noBatch,
                    'stok'           => rand(30, 150),
                    'harga'          => rand(1000, 5000),
                    'tgl_masuk'      => $tglMasuk,
                    'tgl_kadaluarsa' => $kadaluarsa,
                    'supplier'       => 'Pusat Farmasi Nasional',
                ]);
            }
        }
    }
}