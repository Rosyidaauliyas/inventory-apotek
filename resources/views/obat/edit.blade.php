<x-app-layout>
    <div class="max-w-3xl mx-auto py-8">
        <div class="mb-8">
            <a href="{{ route('obat.index') }}" class="text-xs font-black text-blue-600 uppercase tracking-widest hover:text-blue-700">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
            </a>
            <h2 class="text-3xl font-black text-slate-800 tracking-tight mt-4">Edit Data Batch</h2>
            <p class="text-sm text-slate-500 mt-1">Perbarui stok, nomor batch, atau tanggal kadaluarsa.</p>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/60 border border-slate-100 p-10">
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm rounded-r-xl">
                    <p class="font-bold">Ada kesalahan input:</p>
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('obat.update', $obat->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <input type="hidden" name="master_obat_id" value="{{ $obat->master_obat_id }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Nama Obat (Katalog)</label>
                        <input type="text" value="{{ $obat->masterObat->nama_obat }}" readonly 
                               class="w-full px-5 py-4 rounded-2xl border-none bg-slate-100 text-slate-500 font-bold cursor-not-allowed">
                        <p class="text-[9px] text-slate-400 mt-1 ml-1">*Edit nama obat di menu Master Obat</p>
                    </div>
                    <div>
                        {{-- REVISI: No. Batch dibuat Readonly untuk Integritas Data FIFO --}}
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">No. Batch</label>
                        <input type="text" name="batch" value="{{ $obat->batch }}" readonly 
                               class="w-full px-5 py-4 rounded-2xl border-none bg-slate-100 text-slate-500 font-bold cursor-not-allowed">
                        <p class="text-[9px] text-orange-500 mt-1 ml-1 font-bold italic">*Nomor batch tidak dapat diubah untuk menjaga integritas data.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Stok Saat Ini</label>
                        <input type="number" name="stok" value="{{ old('stok', $obat->stok) }}" 
                               class="w-full px-5 py-4 rounded-2xl border-slate-100 bg-slate-50 focus:ring-2 focus:ring-blue-500 transition font-bold text-slate-700 @error('stok') border-red-500 @enderror">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Harga Satuan (Rp)</label>
                        <input type="number" name="harga" value="{{ old('harga', $obat->harga) }}" 
                               class="w-full px-5 py-4 rounded-2xl border-slate-100 bg-slate-50 focus:ring-2 focus:ring-blue-500 transition font-bold text-slate-700 @error('harga') border-red-500 @enderror">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Tanggal Masuk</label>
                        <input type="date" name="tgl_masuk" value="{{ old('tgl_masuk', $obat->tgl_masuk) }}" 
                               class="w-full px-5 py-4 rounded-2xl border-slate-100 bg-slate-50 focus:ring-2 focus:ring-blue-500 transition font-bold text-slate-700 @error('tgl_masuk') border-red-500 @enderror">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Tanggal Kadaluarsa</label>
                        <input type="date" name="tgl_kadaluarsa" value="{{ old('tgl_kadaluarsa', $obat->tgl_kadaluarsa) }}" 
                               class="w-full px-5 py-4 rounded-2xl border-slate-100 bg-slate-50 focus:ring-2 focus:ring-blue-500 transition font-bold text-slate-700 @error('tgl_kadaluarsa') border-red-500 @enderror">
                    </div>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-blue-200 hover:bg-blue-700 transition transform hover:-translate-y-1 mt-4">
                    Simpan Perubahan Batch
                </button>
            </form>
        </div>
    </div>
</x-app-layout>