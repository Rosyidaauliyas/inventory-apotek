<x-app-layout>
    <!-- Tom Select CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">

    <div class="max-w-6xl mx-auto py-8 px-4">
        <h2 class="text-2xl font-black text-slate-800 mb-8 uppercase tracking-tighter">Formulir Pengeluaran Obat (FIFO)</h2>

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-xl shadow-sm">
                <p class="font-bold">Gagal!</p>
                <p class="text-sm">{{ session('error') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-[2rem] shadow-2xl shadow-slate-200/50 border border-slate-100 p-10 mb-8 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1.5 bg-blue-600"></div>

            <form action="{{ route('stok_keluar.store') }}" method="POST" class="space-y-10">
                @csrf
                
                <div class="space-y-3">
                    <label class="block text-blue-700 font-black text-xs uppercase tracking-widest">Langkah 1: Pilih Nama Obat</label>
                    <div class="relative group">
                        <!-- ID 'master_obat_id' akan digunakan oleh Tom Select -->
                        <select name="master_obat_id" id="master_obat_id" required 
                                class="w-full bg-[#F1F5F9] border-none rounded-2xl py-4 px-5 text-slate-700 font-bold text-sm appearance-none cursor-pointer transition-all">
                            <option value="" disabled selected>-- Ketik nama obat atau kode untuk mencari --</option>
                            @foreach($masterObats as $master)
                                <option value="{{ $master->id }}" data-total-stok="{{ $master->total_stok }}">
                                    [{{ $master->kode_obat }}] {{ $master->nama_obat }} (Tersedia: {{ $master->total_stok }} {{ $master->satuan }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <p class="text-[10px] text-slate-400 italic">*Pilih obat, sistem akan otomatis mengambil batch tertua (FIFO).</p>
                </div>

                <div class="space-y-3">
                    <label class="block text-blue-700 font-black text-xs uppercase tracking-widest">Langkah 2: Detail Pengeluaran</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Jumlah Unit Keluar *</label>
                            <input type="number" name="jumlah_keluar" id="jumlah_keluar" required min="1" placeholder="Masukkan angka..." 
                                   class="w-full bg-[#F1F5F9] border-none rounded-2xl py-4 px-5 focus:ring-4 focus:ring-blue-500/10 text-slate-700 font-black text-lg">
                            <p id="info_stok" class="text-[10px] text-blue-500 font-bold mt-1 ml-1">Maksimal pengeluaran: -</p>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Tanggal Keluar *</label>
                            <input type="date" name="tgl_keluar" value="{{ date('Y-m-d') }}" required 
                                   class="w-full bg-[#F1F5F9] border-none rounded-2xl py-4 px-5 focus:ring-4 focus:ring-blue-500/10 text-slate-700 font-bold">
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Keterangan / Tujuan *</label>
                    <textarea name="keterangan" rows="2" required placeholder="Contoh: Pengambilan resep pasien dr. Anam" 
                              class="w-full bg-[#F1F5F9] border-none rounded-2xl py-4 px-5 focus:ring-4 focus:ring-blue-500/10 text-slate-700 font-medium"></textarea>
                </div>

                <div class="flex items-center gap-5 pt-6 border-t border-slate-50">
                    <button type="submit" class="bg-blue-600 text-white font-black uppercase tracking-widest text-[11px] px-12 py-4 rounded-2xl hover:bg-blue-700 transition shadow-2xl shadow-blue-200 transform hover:-translate-y-1">
                        Proses FIFO Sekarang
                    </button>
                    <a href="{{ route('stok_keluar.index') }}" class="text-slate-400 font-black uppercase tracking-widest text-[11px] px-8 py-4 rounded-2xl hover:bg-slate-50 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>

        <div class="bg-blue-50 rounded-[2rem] p-8 border border-blue-100 flex items-start gap-5">
            <div class="bg-blue-600 text-white p-3 rounded-2xl shadow-lg shadow-blue-200">
                <i class="fas fa-info-circle text-xl"></i>
            </div>
            <div>
                <h4 class="text-blue-800 font-black text-sm uppercase tracking-wider mb-2">Automated FIFO Engine Active</h4>
                <p class="text-blue-600/80 text-xs leading-relaxed font-medium">
                    Anda cukup menginputkan jumlah total yang dibutuhkan. Sistem akan secara otomatis melakukan pemindaian batch dari yang paling lama (<span class="font-bold underline">First In</span>) hingga stok terpenuhi, lalu mengeluarkannya terlebih dahulu (<span class="font-bold underline">First Out</span>). Hal ini menjamin akurasi masa kedaluwarsa obat di gudang farmasi.
                </p>
            </div>
        </div>
    </div>

    <!-- Tom Select JS -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        // Inisialisasi Tom Select untuk Pencarian Dropdown
        const medicineSelect = new TomSelect("#master_obat_id", {
            create: false,
            sortField: { field: "text", direction: "asc" }
        });

        // Event listener dipindah ke Tom Select 'change'
        medicineSelect.on('change', function(value) {
            const selectedOption = medicineSelect.options[value];
            const selectElement = document.getElementById('master_obat_id');
            const originalOption = [...selectElement.options].find(o => o.value == value);
            
            if (originalOption) {
                const stokTotal = originalOption.getAttribute('data-total-stok');
                const inputJumlah = document.getElementById('jumlah_keluar');
                const infoStok = document.getElementById('info_stok');

                if (stokTotal) {
                    inputJumlah.max = stokTotal;
                    infoStok.innerText = 'Maksimal pengeluaran: ' + stokTotal + ' unit (Total gabungan semua batch)';
                }
            }
        });

        // Validasi real-time agar tidak melebihi stok total
        document.getElementById('jumlah_keluar').addEventListener('input', function() {
            const max = parseInt(this.max);
            const current = parseInt(this.value);

            if (current > max) {
                alert('Jumlah melebihi total stok yang tersedia di semua batch!');
                this.value = max;
            }
        });
    </script>
</x-app-layout>