<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4">
        
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 mb-6">
            <h2 class="text-lg font-bold text-slate-700 mb-6 flex items-center gap-2">
                <span class="w-2 h-6 bg-blue-600 rounded-full"></span>
                Filter Laporan Persediaan
            </h2>
            <form action="{{ route('laporan.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block">Tanggal Mulai</label>
                        <input type="date" name="tgl_mulai" value="{{ $tglMulai }}" class="w-full bg-slate-50 border-none rounded-2xl py-3 px-4 focus:ring-2 focus:ring-blue-500 font-bold text-slate-700">
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block">Tanggal Akhir</label>
                        <input type="date" name="tgl_akhir" value="{{ $tglAkhir }}" class="w-full bg-slate-50 border-none rounded-2xl py-3 px-4 focus:ring-2 focus:ring-blue-500 font-bold text-slate-700">
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block">Kategori Laporan</label>
                        <select name="jenis_laporan" onchange="this.form.submit()" class="w-full bg-slate-50 border-none rounded-2xl py-3 px-4 focus:ring-2 focus:ring-blue-500 font-bold text-slate-700">
                            <option value="stok_obat" {{ $jenisLaporan == 'stok_obat' ? 'selected' : '' }}>Stok Saat Ini (Keseluruhan)</option>
                            <option value="stok_masuk" {{ $jenisLaporan == 'stok_masuk' ? 'selected' : '' }}>Laporan Stok Masuk</option>
                            <option value="stok_keluar" {{ $jenisLaporan == 'stok_keluar' ? 'selected' : '' }}>Laporan Stok Keluar (FIFO)</option>
                            <option value="kadaluwarsa" {{ $jenisLaporan == 'kadaluwarsa' ? 'selected' : '' }}>Laporan Obat Kadaluarsa</option>
                            <option value="akurasi_stok" {{ $jenisLaporan == 'akurasi_stok' ? 'selected' : '' }}>Laporan Akurasi (Audit)</option>
                        </select>
                    </div>
                </div>

                @if($jenisLaporan == 'akurasi_stok')
                <div class="mt-6 flex items-center gap-3 bg-blue-50/50 p-4 rounded-2xl border border-blue-100/50">
                    <input type="checkbox" name="hanya_selisih" id="hanya_selisih" value="1" 
                           onchange="this.form.submit()"
                           {{ request('hanya_selisih') ? 'checked' : '' }}
                           class="w-5 h-5 text-blue-600 border-slate-300 rounded focus:ring-blue-500 cursor-pointer">
                    <label for="hanya_selisih" class="text-[10px] font-black text-blue-800 uppercase tracking-widest cursor-pointer">
                        Mode Audit: Hanya Tampilkan Obat dengan Selisih Stok
                    </label>
                </div>
                @endif
            </form>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden p-10">
            <div class="text-center mb-10">
                <h3 class="text-2xl font-black text-slate-800 uppercase tracking-tighter">UPTD PUSKESMAS TAROKAN</h3>
                <p class="text-blue-600 font-black uppercase tracking-[0.3em] text-[10px] mt-1">
                    Laporan {{ str_replace('_', ' ', $jenisLaporan) }}
                </p>
                <div class="inline-block px-4 py-1 bg-slate-100 rounded-full mt-3">
                    <p class="text-[10px] font-bold text-slate-500 italic">
                        Periode: {{ date('d/m/Y', strtotime($tglMulai)) }} s/d {{ date('d/m/Y', strtotime($tglAkhir)) }}
                    </p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-separate border-spacing-y-2">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                            <th class="px-6 py-4">No</th>
                            <th class="px-6 py-4">Nama Obat & Batch</th>
                            
                            @if($jenisLaporan == 'stok_keluar')
                                <th class="px-6 py-4 text-center">Qty Keluar</th>
                                <th class="px-6 py-4 text-center">Tujuan / Ket.</th>
                                <th class="px-6 py-4 text-center">Tanggal</th>
                            @elseif($jenisLaporan == 'akurasi_stok')
                                <th class="px-6 py-4 text-center">Stok Sistem</th>
                                <th class="px-6 py-4 text-center">Stok Fisik</th>
                                <th class="px-6 py-4 text-center">Selisih</th>
                                <th class="px-6 py-4 text-center">Petugas</th>
                            @else
                                <th class="px-6 py-4 text-right">Harga Satuan</th>
                                <th class="px-6 py-4 text-center">Sisa Stok</th>
                                <th class="px-6 py-4 text-center">Exp Date</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $key => $item)
                        <tr class="bg-slate-50/50 hover:bg-slate-50 transition duration-200">
                            <td class="px-6 py-4 rounded-l-2xl font-bold text-slate-400">{{ $key + 1 }}</td>
                            <td class="px-6 py-4">
                                <p class="font-black text-slate-700">
                                    @php
                                        if (in_array($jenisLaporan, ['stok_keluar', 'akurasi_stok'])) {
                                            $namaObat = $item->obat?->masterObat?->nama_obat ?? 'Data Dihapus';
                                            $batchObat = $item->obat?->batch ?? '-';
                                        } else {
                                            $namaObat = $item->masterObat?->nama_obat ?? 'Data Dihapus';
                                            $batchObat = $item->batch ?? '-';
                                        }
                                    @endphp
                                    {{ $namaObat }}
                                </p>
                                <span class="text-[9px] font-bold text-blue-500 uppercase tracking-widest">
                                    Batch: {{ $batchObat }}
                                </span>
                            </td>
                            
                            @if($jenisLaporan == 'stok_keluar')
                                <td class="px-6 py-4 text-center font-black text-blue-600">{{ $item->jumlah_keluar }}</td>
                                <td class="px-6 py-4 text-center text-xs text-slate-500">{{ $item->keterangan ?? '-' }}</td>
                                <td class="px-6 py-4 text-center font-bold text-slate-500 text-xs">{{ date('d/m/Y', strtotime($item->tgl_keluar)) }}</td>
                            @elseif($jenisLaporan == 'akurasi_stok')
                                <td class="px-6 py-4 text-center font-bold text-slate-400">{{ $item->stok_sistem }}</td>
                                <td class="px-6 py-4 text-center font-bold text-slate-700">{{ $item->stok_fisik }}</td>
                                <td class="px-6 py-4 text-center font-black {{ ($item->selisih ?? 0) != 0 ? 'text-rose-500' : 'text-emerald-500' }}">
                                    {{ ($item->selisih ?? 0) > 0 ? '+' : '' }}{{ $item->selisih ?? 0 }}
                                </td>
                                <td class="px-6 py-4 text-center text-[10px] font-bold uppercase text-slate-400">{{ $item->petugas }}</td>
                            @else
                                <td class="px-6 py-4 text-right font-bold text-slate-600">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-center font-black text-slate-700">{{ $item->stok }}</td>
                                <td class="px-6 py-4 text-center text-xs font-bold {{ $item->tgl_kadaluarsa <= now() ? 'text-rose-500' : 'text-slate-500' }}">
                                    {{ date('d/m/Y', strtotime($item->tgl_kadaluarsa)) }}
                                </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-20 text-slate-400 italic font-medium">
                                Belum ada data terekam untuk periode dan kategori ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex justify-center mt-12">
                <a href="{{ route('laporan.cetak_pdf', ['tgl_mulai' => $tglMulai, 'tgl_akhir' => $tglAkhir, 'jenis_laporan' => $jenisLaporan, 'hanya_selisih' => request('hanya_selisih')]) }}" 
                   target="_blank"
                   class="group bg-blue-600 hover:bg-blue-700 text-white font-black px-12 py-4 rounded-2xl shadow-xl shadow-blue-200 transition-all transform hover:-translate-y-1 flex items-center gap-3">
                    <i class="fas fa-file-pdf"></i>
                    <span class="text-[11px] uppercase tracking-[0.2em]">Pratinjau Laporan PDF</span>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>