<x-app-layout>
    <!-- Tambahan Tom Select CSS untuk fitur pencarian -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">

    <div class="max-w-6xl mx-auto py-8 px-4">
        <h2 class="text-2xl font-black text-slate-800 mb-8 uppercase tracking-tighter">Formulir Input Stok Masuk</h2>

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-xl shadow-sm">
                <p class="font-bold">Berhasil!</p>
                <p class="text-sm">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-[2rem] shadow-2xl shadow-slate-200/50 border border-slate-100 p-10 mb-8 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1.5 bg-blue-600"></div>

            <form action="{{ route('obat.store') }}" method="POST" class="space-y-10">
                @csrf
                
                <div class="space-y-3">
                    <label class="block text-blue-700 font-black text-xs uppercase tracking-widest">Pilih Obat dari Katalog *</label>
                    <div class="relative group">
                        <!-- Select ID tetap "master_obat_select" untuk diinisialisasi Tom Select -->
                        <select name="master_obat_id" id="master_obat_select" required
                                class="w-full bg-[#F1F5F9] border-none rounded-2xl py-4 px-5 focus:ring-4 focus:ring-blue-500/10 text-slate-700 font-bold text-sm transition-all">
                            <option value="" disabled selected>-- Ketik nama obat untuk mencari di katalog... --</option>
                            @foreach($masterObats as $master)
                                <option value="{{ $master->id }}" {{ old('master_obat_id') == $master->id ? 'selected' : '' }}>
                                    {{ $master->nama_obat }} {{ $master->kekuatan_dosis ?? '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <p class="text-[10px] text-slate-400 italic">*Jika obat tidak ada, tambahkan dulu di menu <a href="{{ route('master_obat.index') }}" class="text-blue-600 hover:underline">Master Obat</a>.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nomor Batch (Otomatis) *</label>
                        <input type="text" name="batch" id="batch_display" value="{{ old('batch') }}" required 
                               placeholder="Pilih obat untuk membuat batch..." 
                               class="w-full bg-slate-100 border-none rounded-2xl py-4 px-5 text-slate-400 font-bold cursor-not-allowed" readonly>
                        <p class="text-[9px] text-blue-500 font-bold italic ml-1">*System-generated berdasarkan inisial obat.</p>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Jumlah Masuk (Pcs) *</label>
                        <input type="number" name="stok" value="{{ old('stok') }}" required min="1" placeholder="Cth: 100" class="w-full bg-[#F1F5F9] border-none rounded-2xl py-4 px-5 focus:ring-4 focus:ring-blue-500/10 text-slate-700 font-bold">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Tanggal Masuk *</label>
                        <input type="date" name="tgl_masuk" value="{{ old('tgl_masuk', date('Y-m-d')) }}" required class="w-full bg-[#F1F5F9] border-none rounded-2xl py-4 px-5 focus:ring-4 focus:ring-blue-500/10 text-slate-700 font-bold">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Tanggal Kadaluarsa *</label>
                        <input type="date" name="tgl_kadaluarsa" value="{{ old('tgl_kadaluarsa') }}" required class="w-full bg-[#F1F5F9] border-none rounded-2xl py-4 px-5 focus:ring-4 focus:ring-blue-500/10 text-slate-700 font-bold">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Harga per Pcs (Rp) *</label>
                        <input type="number" name="harga" value="{{ old('harga') }}" required min="0" placeholder="Cth: 1500" class="w-full bg-[#F1F5F9] border-none rounded-2xl py-4 px-5 focus:ring-4 focus:ring-blue-500/10 text-slate-700 font-bold text-blue-600">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Supplier</label>
                        <input type="text" name="supplier" value="{{ old('supplier') }}" placeholder="Cth: PT. Pharma Jaya" class="w-full bg-[#F1F5F9] border-none rounded-2xl py-4 px-5 focus:ring-4 focus:ring-blue-500/10 text-slate-700 font-bold">
                    </div>
                </div>

                <div class="flex items-center gap-5 pt-6 border-t border-slate-50">
                    <button type="submit" class="bg-blue-600 text-white font-black uppercase tracking-widest text-[11px] px-12 py-4 rounded-2xl hover:bg-blue-700 transition shadow-2xl shadow-blue-200 transform hover:-translate-y-1">
                        Simpan Stok Masuk
                    </button>
                    <a href="{{ route('obat.index') }}" class="text-slate-400 font-black uppercase tracking-widest text-[11px] px-8 py-4 rounded-2xl hover:bg-slate-50 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>

        {{-- Riwayat Input Hari Ini --}}
        @if(isset($riwayatHariIni) && $riwayatHariIni->isNotEmpty())
        <div class="mt-12">
            <h3 class="text-lg font-bold text-slate-600 mb-4">Riwayat Input Hari Ini</h3>
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="table-responsive">
                    <table class="w-full text-sm">
                        <thead class="text-left text-slate-400">
                            <tr>
                                <th class="p-3">Obat</th>
                                <th class="p-3">Batch</th>
                                <th class="p-3">Stok</th>
                                <th class="p-3">Kadaluarsa</th>
                            </tr>
                        </thead>
                        <tbody class="font-semibold text-slate-600">
                            @foreach($riwayatHariIni as $riwayat)
                            <tr class="border-t border-slate-100">
                                <td class="p-3">{{ $riwayat->masterObat->nama_obat ?? 'N/A' }}</td>
                                <td class="p-3">
                                    <span class="bg-blue-50 text-blue-600 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest">
                                        {{ $riwayat->batch }}
                                    </span>
                                </td>
                                <td class="p-3">{{ $riwayat->stok }}</td>
                                <td class="p-3">{{ \Carbon\Carbon::parse($riwayat->tgl_kadaluarsa)->format('d M Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Script Tom Select JS & Logika Otomatisasi -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        // Inisialisasi Tom Select pada dropdown katalog
        const control = new TomSelect("#master_obat_select", {
            create: false,
            sortField: { field: "text", direction: "asc" },
            placeholder: "-- Ketik nama obat untuk mencari... --"
        });

        // Event listener saat pilihan obat berubah melalui Tom Select
        control.on('change', function(value) {
            const selectElement = document.getElementById('master_obat_select');
            const batchInput = document.getElementById('batch_display');
            
            // Mencari teks dari opsi yang dipilih
            const selectedOption = control.options[value];
            
            if (selectedOption && value !== "") {
                const medicineName = selectedOption.text.trim();
                // Ambil 3 huruf pertama, hilangkan spasi
                const inisial = medicineName.substring(0, 3).replace(/\s/g, 'X').toUpperCase();
                // Berikan preview batch otomatis ke user
                batchInput.value = "BCH-" + inisial + "-[AUTO]";
            } else {
                batchInput.value = "";
            }
        });
    </script>
</x-app-layout>