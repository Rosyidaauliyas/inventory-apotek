<x-app-layout>
    <div class="p-8">
        <div class="mb-6">
            <a href="{{ route('master_obat.index') }}" class="flex items-center text-blue-600 font-bold text-sm hover:underline">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                KEMBALI KE DAFTAR
            </a>
        </div>

        <div class="mb-10">
            <h1 class="text-4xl font-extrabold text-slate-800">Edit Data Master Obat</h1>
            <p class="text-slate-500 mt-2">Perbarui informasi katalog obat untuk puskesmas.</p>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/60 p-12 max-w-5xl">
            <form action="{{ route('master_obat.update', $masterObat->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                    
                    <div class="space-y-3">
                        <label class="flex items-center text-xs font-black text-slate-400 tracking-widest uppercase">
                            <i class="fas fa-hashtag mr-2 text-blue-500"></i> KODE OBAT
                        </label>
                        <input type="text" 
                            class="w-full bg-slate-50 border-none text-slate-400 text-lg font-bold rounded-2xl p-5 cursor-not-allowed focus:ring-0" 
                            value="{{ $masterObat->kode_obat }}" 
                            readonly>
                        <p class="text-[10px] text-slate-300 italic">* Kode diatur otomatis oleh sistem</p>
                    </div>

                    <div class="space-y-3">
                        <label class="flex items-center text-xs font-black text-slate-400 tracking-widest uppercase">
                            <i class="fas fa-pills mr-2 text-blue-500"></i> NAMA OBAT
                        </label>
                        <input type="text" name="nama_obat" 
                            class="w-full bg-slate-50 border-none text-slate-700 text-lg font-bold rounded-2xl p-5 focus:ring-2 focus:ring-blue-500 transition-all shadow-sm @error('nama_obat') ring-2 ring-red-500 @enderror" 
                            value="{{ old('nama_obat', $masterObat->nama_obat) }}" required>
                    </div>

                    <div class="space-y-3">
                        <label class="flex items-center text-xs font-black text-slate-400 tracking-widest uppercase">
                            <i class="fas fa-layer-group mr-2 text-blue-500"></i> GOLONGAN
                        </label>
                        <select name="golongan" 
                            class="w-full bg-slate-50 border-none text-slate-700 text-lg font-bold rounded-2xl p-5 focus:ring-2 focus:ring-blue-500 transition-all shadow-sm">
                            <option value="Umum" {{ $masterObat->golongan == 'Umum' ? 'selected' : '' }}>Umum</option>
                            <option value="Antibiotik" {{ $masterObat->golongan == 'Antibiotik' ? 'selected' : '' }}>Antibiotik</option>
                            <option value="Vitamin" {{ $masterObat->golongan == 'Vitamin' ? 'selected' : '' }}>Vitamin</option>
                        </select>
                    </div>

                    <div class="space-y-3">
                        <label class="flex items-center text-xs font-black text-slate-400 tracking-widest uppercase">
                            <i class="fas fa-box mr-2 text-blue-500"></i> SATUAN
                        </label>
                        <input type="text" name="satuan" 
                            class="w-full bg-slate-50 border-none text-slate-700 text-lg font-bold rounded-2xl p-5 focus:ring-2 focus:ring-blue-500 transition-all shadow-sm" 
                            value="{{ old('satuan', $masterObat->satuan) }}" required>
                    </div>

                    <div class="space-y-3">
                        <label class="flex items-center text-xs font-black text-slate-400 tracking-widest uppercase">
                            <i class="fas fa-exclamation-triangle mr-2 text-blue-500"></i> STOK MINIMAL (EWS)
                        </label>
                        <input type="number" name="stok_minimal" 
                            class="w-full bg-slate-50 border-none text-slate-700 text-lg font-bold rounded-2xl p-5 focus:ring-2 focus:ring-blue-500 transition-all shadow-sm" 
                            value="{{ old('stok_minimal', $masterObat->stok_minimal) }}" required>
                        <p class="text-[10px] text-slate-300 italic">* Batas minimal sebelum peringatan dashboard muncul</p>
                    </div>

                </div>

                <div class="mt-12 flex items-center justify-end space-x-6">
                    <a href="{{ route('master_obat.index') }}" class="text-sm font-bold text-slate-400 hover:text-slate-600 transition">
                        BATAL
                    </a>
                    <button type="submit" 
                        class="px-10 py-5 bg-blue-600 text-white font-black text-sm rounded-2xl shadow-xl shadow-blue-200 hover:bg-blue-700 hover:-translate-y-1 transition-all duration-300">
                        SIMPAN PERUBAHAN
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>