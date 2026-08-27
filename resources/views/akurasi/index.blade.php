<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-6">
        <div class="flex justify-between items-start mb-8">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Pemeriksaan Stok Fisik</h2>
                <p class="text-sm text-slate-500">Bandingkan jumlah di sistem dengan jumlah nyata di gudang</p>
            </div>
            <div class="text-right">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Tanggal Pemeriksaan:</p>
                <p class="text-lg font-black text-blue-700">{{ now()->translatedFormat('d F Y') }}</p>
            </div>
        </div>

        <!-- FITUR SEARCH: Untuk memfilter tabel yang ribuan -->
        <div class="mb-6 relative">
            <input type="text" id="searchInput" 
                   placeholder="Cari nama obat atau nomor batch untuk dicek..." 
                   class="w-full pl-12 pr-4 py-4 rounded-2xl border-none bg-white shadow-xl shadow-slate-200/50 focus:ring-4 focus:ring-blue-500/10 font-bold text-slate-700">
            <div class="absolute left-5 top-4.5 text-blue-500">
                <i class="fas fa-search"></i>
            </div>
        </div>

        <form action="{{ route('akurasi.store') }}" method="POST">
            @csrf
            <div class="bg-white rounded-[2rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                <table class="w-full text-left border-collapse" id="tableAkurasi">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100">
                            <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase">Nama Obat</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase">No. Batch</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase text-center">Stok Sistem</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase text-center">Stok Fisik</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase text-center">Selisih</th>
                            <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($obats as $obat)
                        <tr class="row-obat transition-colors hover:bg-slate-50/50">
                            <input type="hidden" name="obat_id[]" value="{{ $obat->id }}">
                            <td class="px-6 py-5 text-sm font-semibold text-slate-700 nama-obat">{{ $obat->masterObat->nama_obat }}</td>
                            <td class="px-6 py-5 text-sm text-slate-400 font-mono no-batch">{{ $obat->batch }}</td>
                            <td class="px-6 py-5 text-center text-sm font-bold text-blue-600 stok-sistem">{{ $obat->stok }}</td>
                            <td class="px-6 py-5 text-center">
                                <input type="number" name="stok_fisik[]" value="{{ $obat->stok }}" 
                                    class="input-fisik w-24 text-center py-2 border-slate-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm font-bold">
                            </td>
                            <td class="px-6 py-5 text-center text-sm font-bold text-slate-700 selisih">0</td>
                            <td class="px-6 py-5 text-center">
                                <span class="status-badge px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter bg-emerald-50 text-emerald-600 border border-emerald-100">
                                    Sesuai
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="p-6 bg-slate-50/50 flex justify-end items-center gap-4 border-t border-slate-100">
                    <a href="{{ route('dashboard') }}" class="text-sm font-bold text-slate-500 hover:text-slate-700">Batal</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold text-sm shadow-lg shadow-blue-200 transition transform active:scale-95">
                        Simpan Hasil Pemeriksaan
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Fitur 1: Pencarian / Filter Real-time
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const rows = document.querySelectorAll('.row-obat');

            rows.forEach(row => {
                const nama = row.querySelector('.nama-obat').innerText.toLowerCase();
                const batch = row.querySelector('.no-batch').innerText.toLowerCase();
                
                if (nama.includes(filter) || batch.includes(filter)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });

        // Fitur 2: Kalkulasi Selisih (Logic Asli Lu)
        document.querySelectorAll('.input-fisik').forEach(input => {
            input.addEventListener('input', function() {
                const row = this.closest('.row-obat');
                const stokSistem = parseInt(row.querySelector('.stok-sistem').innerText);
                const stokFisik = parseInt(this.value) || 0;
                const selisihField = row.querySelector('.selisih');
                const badge = row.querySelector('.status-badge');

                const selisih = stokFisik - stokSistem;
                selisihField.innerText = selisih;

                if (selisih === 0) {
                    badge.innerText = 'Sesuai';
                    badge.className = 'status-badge px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter bg-emerald-50 text-emerald-600 border border-emerald-100';
                    selisihField.className = 'px-6 py-5 text-center text-sm font-bold text-slate-700 selisih';
                } else {
                    badge.innerText = 'Tidak Sesuai';
                    badge.className = 'status-badge px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter bg-rose-50 text-rose-600 border border-rose-100';
                    selisihField.className = 'px-6 py-5 text-center text-sm font-bold text-rose-600 selisih';
                }
            });
        });
    </script>
</x-app-layout>