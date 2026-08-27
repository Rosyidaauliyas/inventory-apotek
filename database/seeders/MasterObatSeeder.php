<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MasterObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
DB::table('master_obats')->insert([
            ['kode_obat' => 'OBT-A1-001', 'nama_obat' => "Amlodipin Besilat Tablet 10 mg", 'golongan' => 'Umum', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-A2-002', 'nama_obat' => "Amoksisilin Kaptab 500 mg", 'golongan' => 'Antibiotik', 'satuan' => 'Kaplet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-A3-003', 'nama_obat' => "Aqua Proinjeksi Steril, Bebas Pirogen", 'golongan' => 'Umum', 'satuan' => 'Injeksi', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-A4-004', 'nama_obat' => "Asam Mefenamat Tablet 500 mg", 'golongan' => 'Umum', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-A5-005', 'nama_obat' => "Asam Traneksamat Tablet 500 mg", 'golongan' => 'Umum', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-A6-006', 'nama_obat' => "Asiklovir Tablet 400 mg", 'golongan' => 'Umum', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-A7-007', 'nama_obat' => "Atapulgit Molagit Tablet", 'golongan' => 'Umum', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-B1-008', 'nama_obat' => "Bisoprolol Tablet 5 mg", 'golongan' => 'Umum', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-D1-009', 'nama_obat' => "Deksametason Inj.5 mg/ml - 1 ml", 'golongan' => 'Umum', 'satuan' => 'Injeksi', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-D2-010', 'nama_obat' => "Digoxin tablet 0,25 mg", 'golongan' => 'Umum', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-D3-011', 'nama_obat' => "Dimenhidrinat Tablet 50 mg", 'golongan' => 'Umum', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-D4-012', 'nama_obat' => "Domperidon Tablet 10 mg", 'golongan' => 'Umum', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-E1-013', 'nama_obat' => "Eritromisin Tablet 500 mg", 'golongan' => 'Antibiotik', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-F1-014', 'nama_obat' => "Fitomenadion ( Vit. K ) Tablet Salut 10 mg", 'golongan' => 'Vitamin', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-G1-015', 'nama_obat' => "Glibenklamid Tablet 5 mg", 'golongan' => 'Umum', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-G2-016', 'nama_obat' => "Glikazid Tablet 80 mg", 'golongan' => 'Umum', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-G3-017', 'nama_obat' => "Glimepirid Tablet 1 mg", 'golongan' => 'Umum', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-G4-018', 'nama_obat' => "Glimepirid Tablet 2 mg", 'golongan' => 'Umum', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-I1-019', 'nama_obat' => "Ibuprofen Tablet 200 mg", 'golongan' => 'Umum', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-i2-020', 'nama_obat' => "Ibuprofen Tablet 400 mg", 'golongan' => 'Umum', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-K1-021', 'nama_obat' => "Kaptopril Tablet 12,5 mg", 'golongan' => 'Umum', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-K1-022', 'nama_obat' => "Kaptopril Tablet 25 mg", 'golongan' => 'Umum', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-K2-023', 'nama_obat' => "Ketokonazol Tablet 200 mg", 'golongan' => 'Umum', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-K3-024', 'nama_obat' => "Klindamsin Tablet 150 mg", 'golongan' => 'Antibiotik', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-K4-025', 'nama_obat' => "Klorfeniramin Meleat (CTM) Tablet 4 mg", 'golongan' => 'Umum', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-K5-026', 'nama_obat' => "Kotrimoksasol (Dewasa) Kombinasi : Sulfametoksazol 400 mg +Trimetoprim 80 mg Tablet", 'golongan' => 'Umum', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-L1-027', 'nama_obat' => "Lisinopril Tablet 5 mg", 'golongan' => 'Umum', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-L2-028', 'nama_obat' => "Loratadin Tablet 10 mg", 'golongan' => 'Umum', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-P1-029', 'nama_obat' => "Piridoksin (Vitamin B6) Tablet 10 mg", 'golongan' => 'Vitamin', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-P2-030', 'nama_obat' => "Prednison Tablet 5 mg", 'golongan' => 'Umum', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-R1-031', 'nama_obat' => "Ranitidin Tablet 150 mg", 'golongan' => 'Umum', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-S1-032', 'nama_obat' => "Salbutamol Tablet 2 mg", 'golongan' => 'Umum', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-S2-033', 'nama_obat' => "Setirizine Tablet 10 mg", 'golongan' => 'Umum', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-S3-034', 'nama_obat' => "Simvastatin Tablet 20 mg", 'golongan' => 'Umum', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-T1-035', 'nama_obat' => "Tiamin (Vit B1) Tablet 10 mg", 'golongan' => 'Vitamin', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-V1-036', 'nama_obat' => "Vitamin B Kompleks Tablet", 'golongan' => 'Vitamin', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-Z1-037', 'nama_obat' => "Zinc Tablet 20 mg", 'golongan' => 'Umum', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-A8-038', 'nama_obat' => "Asam Askorbat ( Vit C ) Tablet 50 mg PKM", 'golongan' => 'Vitamin', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-K6-039', 'nama_obat' => "Klindamsin Tablet 300 mg PKM", 'golongan' => 'Antibiotik', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-L3-040', 'nama_obat' => "Lidokain Kombinasi (Anastetik lokal gigi kombinasi KDT/FDC : Lidocain 2% + epinefrin) PKM", 'golongan' => 'Umum', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-L4-041', 'nama_obat' => "Loperamide tablet 2 mg PKM", 'golongan' => 'Umum', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-N1-042', 'nama_obat' => "Nifedipin kaplet 10 mg PKM", 'golongan' => 'Umum', 'satuan' => 'Kaplet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-P3-043', 'nama_obat' => "Piracetam tablet 800 mg PKM", 'golongan' => 'Umum', 'satuan' => 'Tablet', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-R2-044', 'nama_obat' => "Ranitidin injeksi PKM", 'golongan' => 'Umum', 'satuan' => 'Injeksi', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-E2-045', 'nama_obat' => "epinefrin injeksi 1 mg/ml", 'golongan' => 'Umum', 'satuan' => 'Injeksi', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-S4-046', 'nama_obat' => "Sefotaxim 1 g Inj PKM", 'golongan' => 'Antibiotik', 'satuan' => 'Injeksi', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-D5-047', 'nama_obat' => "Difenhidramin Hcl Inj PKM", 'golongan' => 'Umum', 'satuan' => 'Injeksi', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-K7-048', 'nama_obat' => "Ketorolac Trometamin Inj PKM", 'golongan' => 'Umum', 'satuan' => 'Injeksi', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-O1-049', 'nama_obat' => "Ondansetron Inj 4 mg/ml PKM", 'golongan' => 'Umum', 'satuan' => 'Injeksi', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
            ['kode_obat' => 'OBT-N2-050', 'nama_obat' => "Nasal O2 Dws PKM", 'golongan' => 'Umum', 'satuan' => 'Pcs', 'stok_minimal' => 10, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}