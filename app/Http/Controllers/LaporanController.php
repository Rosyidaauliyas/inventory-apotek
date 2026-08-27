<?php

namespace App\Http\Controllers;

use App\Models\MasterObat;
use App\Models\Obat;
use App\Models\StokKeluar;
use App\Models\AkurasiStok;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tglMulai = $request->input('tgl_mulai', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $tglAkhir = $request->input('tgl_akhir', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $jenisLaporan = $request->input('jenis_laporan', 'stok_obat');

        $data = $this->getReportData($jenisLaporan, $tglMulai, $tglAkhir);

        return view('laporan.index', compact('data', 'tglMulai', 'tglAkhir', 'jenisLaporan'));
    }

    public function cetakPdf(Request $request)
    {
        $tglMulai = $request->input('tgl_mulai');
        $tglAkhir = $request->input('tgl_akhir');
        $jenisLaporan = $request->input('jenis_laporan');

        $data = $this->getReportData($jenisLaporan, $tglMulai, $tglAkhir);

        $pdf = Pdf::loadView('laporan.pdf_laporan', compact('data', 'tglMulai', 'tglAkhir', 'jenisLaporan'));
        
        return $pdf->stream('Laporan_'.$jenisLaporan.'_'.now()->format('Ymd').'.pdf');
    }

    private function getReportData($jenis, $start, $end)
    {
        $startDate = Carbon::parse($start)->startOfDay();
        $endDate = Carbon::parse($end)->endOfDay();

        return match ($jenis) {
            'stok_masuk'   => Obat::with('masterObat')
                                ->whereHas('masterObat')
                                ->whereBetween('tgl_masuk', [$start, $end])
                                ->latest()
                                ->get(),

            'stok_keluar'  => StokKeluar::with(['obat.masterObat'])
                                ->whereHas('obat.masterObat')
                                ->whereBetween('tgl_keluar', [$start, $end])
                                ->latest()
                                ->get(),

            'kadaluwarsa'  => Obat::with('masterObat')
                                ->whereHas('masterObat')
                                ->where('tgl_kadaluarsa', '<=', now()->addMonths(6))
                                ->where('stok', '>', 0)
                                ->orderBy('tgl_kadaluarsa', 'asc')
                                ->get(),

            'akurasi_stok' => AkurasiStok::with(['obat.masterObat'])
                                ->whereHas('obat.masterObat')
                                ->whereBetween('created_at', [$startDate, $endDate])
                                // Filter selisih jika checkbox diaktifkan
                                ->when(request('hanya_selisih'), function($q) {
                                    return $q->where('selisih', '!=', 0);
                                })
                                ->latest()
                                ->get(),

            default        => Obat::with('masterObat')
                                ->whereHas('masterObat')
                                ->where('stok', '>', 0)
                                ->orderBy('tgl_kadaluarsa', 'asc')
                                ->get(),
        };
    }
}