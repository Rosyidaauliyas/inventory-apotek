<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\MasterObat;
use App\Models\AkurasiStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ObatController extends Controller
{
    /**
     * DASHBOARD: Ringkasan statistik (Early Warning System)
     * Memisahkan stok AMAN dan yang KADALUARSA dengan filter MasterObat aktif.
     */
    public function indexDashboard()
    {
        $now = now();
        
        $summary = (object) [
            'totalObat'       => MasterObat::count(),
            
            // Stok Aman: Stok > 0, Belum Kadaluarsa, dan MasterObat-nya masih ada
            'totalStokAman'   => Obat::whereHas('masterObat')
                                    ->where('stok', '>', 0)
                                    ->whereDate('tgl_kadaluarsa', '>', $now)
                                    ->sum('stok'),
            
            'stokHampirHabis' => MasterObat::all()->filter(fn($m) => $m->is_kritis)->count(),
            
            // Peringatan: Kadaluarsa dalam 6 bulan ke depan
            'hampirExp'       => Obat::whereHas('masterObat')
                                    ->where('stok', '>', 0)
                                    ->whereBetween('tgl_kadaluarsa', [$now, $now->copy()->addMonths(6)])
                                    ->count(),
            
            // Stok Rusak: Sudah lewat tanggal kadaluarsa tapi stok masih tercatat
            'obatKadaluarsa'  => Obat::whereHas('masterObat')
                                    ->whereDate('tgl_kadaluarsa', '<=', $now)
                                    ->where('stok', '>', 0)
                                    ->count(),
                                    
            'stokMasukHariIni' => Obat::whereDate('created_at', Carbon::today())->count(),
        ];

        // Tampilkan aktivitas batch terbaru (Eager Loading masterObat)
        $obats = Obat::with('masterObat')
                    ->whereHas('masterObat')
                    ->latest()
                    ->take(5)
                    ->get();

        return view('dashboard', compact('summary', 'obats'));
    }

    /**
     * INDEX: Daftar seluruh inventori (Batch) dengan fitur Search
     */
    public function index(Request $request)
    {
        $query = Obat::with('masterObat')->whereHas('masterObat');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('batch', 'like', "%{$search}%")
                  ->orWhereHas('masterObat', function($master) use ($search) {
                      $master->where('nama_obat', 'like', "%{$search}%");
                  });
            });
        }

        $semuaObat = $query->latest()->paginate(10)->withQueryString();

        return view('obat.index', compact('semuaObat'));
    }

    /**
     * CREATE: Form Input Stok Masuk
     */
    public function create()
    {
        // Hanya ambil master obat yang aktif
        $masterObats = MasterObat::orderBy('nama_obat', 'asc')->get();
        
        $riwayatHariIni = Obat::with('masterObat')
                            ->whereHas('masterObat')
                            ->whereDate('created_at', Carbon::today())
                            ->latest()
                            ->get();

        return view('obat.create', compact('masterObats', 'riwayatHariIni'));
    }

    /**
     * STORE: Simpan batch stok baru dengan GENERATE BATCH OTOMATIS
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'master_obat_id' => 'required|exists:master_obats,id',
            'stok'           => 'required|integer|min:1',
            'harga'          => 'required|integer|min:1',
            'tgl_masuk'      => 'required|date',
            'tgl_kadaluarsa' => 'required|date|after:tgl_masuk',
            'supplier'       => 'nullable|string|max:255',
        ]);

        // LOGIKA OTOMATISASI BATCH (Rekomendasi Pak Asmunin)
        $master = MasterObat::findOrFail($request->master_obat_id);
        
        // Ambil 3 huruf pertama nama obat, ganti spasi dengan 'X' jika ada
        $inisial = strtoupper(substr(str_replace(' ', 'X', $master->nama_obat), 0, 3));
        
        // Hitung total batch yang pernah masuk untuk obat ini
        $lastBatchCount = Obat::where('master_obat_id', $master->id)->count();
        $nextNumber = str_pad($lastBatchCount + 1, 3, '0', STR_PAD_LEFT);
        
        // Format Akhir: BCH-DOM-001
        $validated['batch'] = "BCH-{$inisial}-{$nextNumber}";

        Obat::create($validated);

        return redirect()->route('obat.index')->with('success', "Stok batch {$validated['batch']} berhasil ditambahkan secara otomatis.");
    }

    /**
     * EDIT: Form Edit Data Batch
     */
    public function edit($id)
    {
        $obat = Obat::with('masterObat')->findOrFail($id);
        $masterObats = MasterObat::orderBy('nama_obat', 'asc')->get();
        
        return view('obat.edit', compact('obat', 'masterObats'));
    }

    /**
     * UPDATE: Perbarui data batch
     */
    public function update(Request $request, $id)
    {
        $obat = Obat::findOrFail($id);
        
        $validated = $request->validate([
            'master_obat_id' => 'required|exists:master_obats,id',
            'batch'          => 'required|string|max:255',
            'stok'           => 'required|integer|min:0',
            'harga'          => 'required|integer|min:0',
            'tgl_masuk'      => 'required|date',
            'tgl_kadaluarsa' => 'required|date|after:tgl_masuk',
            'supplier'       => 'nullable|string|max:255',
        ]);

        $obat->update($validated);
        
        return redirect()->route('obat.index')->with('success', 'Data batch berhasil diperbarui.');
    }

    /**
     * DESTROY: Hapus data batch
     */
    public function destroy($id)
    {
        $obat = Obat::findOrFail($id);
        $obat->delete();
        
        return redirect()->route('obat.index')->with('success', 'Data batch telah dihapus.');
    }

    /**
     * AKURASI: View Stock Opname (Audit Fisik)
     */
    public function indexAkurasi()
    {
        // Menampilkan data yang masih memiliki stok untuk diaudit
        $obats = Obat::with('masterObat')
                    ->whereHas('masterObat')
                    ->where('stok', '>', 0)
                    ->latest()
                    ->get();

        return view('akurasi.index', compact('obats'));
    }

    /**
     * STORE AKURASI: Simpan hasil audit fisik ke riwayat akurasi
     */
    public function storeAkurasi(Request $request)
    {
        $request->validate([
            'obat_id' => 'required|array',
            'stok_fisik' => 'required|array',
        ]);

        DB::transaction(function() use ($request) {
            foreach ($request->obat_id as $index => $id) {
                $obat = Obat::find($id);
                
                if ($obat) {
                    $fisik = (int) $request->stok_fisik[$index];
                    $stokSistemLama = $obat->stok;

                    // Catat ke tabel history akurasi
                    AkurasiStok::create([
                        'obat_id'        => $id,
                        'stok_sistem'    => $stokSistemLama,
                        'stok_fisik'     => $fisik,
                        'selisih'        => $fisik - $stokSistemLama,
                        'tgl_pengecekan' => now(),
                        'petugas'        => auth()->user()->name, 
                    ]);

                    // Sinkronisasi stok di tabel obat agar sesuai fisik
                    $obat->update(['stok' => $fisik]);
                }
            }
        });

        // Redirect langsung ke laporan audit agar user bisa lihat hasilnya
        return redirect()->route('laporan.index', ['jenis_laporan' => 'akurasi_stok'])
                         ->with('success', 'Sinkronisasi stok fisik berhasil dicatat dan diperbarui.');
    }
}