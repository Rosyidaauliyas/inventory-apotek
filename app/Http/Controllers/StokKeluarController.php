<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\MasterObat;
use App\Models\StokKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StokKeluarController extends Controller
{
    public function index()
    {
        $stokKeluar = StokKeluar::with('obat.masterObat')->latest()->paginate(15); 
        return view('stok_keluar.index', compact('stokKeluar'));
    }
    
    public function create()
    {
        $masterObats = MasterObat::whereHas('batches', function($q) {
            $q->where('stok', '>', 0)
              ->whereDate('tgl_kadaluarsa', '>', now());
        })->orderBy('nama_obat', 'asc')->get();

        return view('stok_keluar.create', compact('masterObats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'master_obat_id' => 'required|exists:master_obats,id',
            'jumlah_keluar' => 'required|integer|min:1',
            'tgl_keluar' => 'required|date',
            'keterangan' => 'required|string|max:255'
        ]);

        $masterObat = MasterObsat::findOrFail($validated['master_obat_id']);
        $jumlahDiminta = (int) $validated['jumlah_keluar'];

        try {
            DB::transaction(function () use ($masterObat, $jumlahDiminta, $validated) {
                
                // LOGIKA FIFO: AMBIL BATCH TERSTUA YANG BELUM KADALUARSA
                $batches = $masterObat->batches()
                                ->where('stok', '>', 0)
                                ->whereDate('tgl_kadaluarsa', '>', now())
                                ->orderBy('tgl_masuk', 'asc') 
                                ->lockForUpdate()
                                ->get();

                if ($batches->sum('stok') < $jumlahDiminta) {
                    throw ValidationException::withMessages([
                        'jumlah_keluar' => "Stok aman tidak mencukupi. Sisa stok {$masterObat->nama_obat} yang belum kadaluarsa hanya {$batches->sum('stok')} unit.",
                    ]);
                }

                $sisaKebutuhan = $jumlahDiminta;

                foreach ($batches as $batch) {
                    if ($sisaKebutuhan <= 0) break;

                    $ambil = min($batch->stok, $sisaKebutuhan); 
                    $batch->decrement('stok', $ambil); 

                    StokKeluar::create([  
                        'obat_id' => $batch->id,
                        'jumlah_keluar' => $ambil,
                        'tgl_keluar' => $validated['tgl_keluar'],
                        'keterangan' => $validated['keterangan'] . " (Otomatis FIFO dari Batch: {$batch->batch})"
                    ]);

                    $sisaKebutuhan -= $ambil; 
            });
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())->withInput();
        }

        return redirect()->route('stok_keluar.index')->with('success', "Berhasil! {$jumlahDiminta} unit telah dikeluarkan dari batch yang aman.");
    }
}