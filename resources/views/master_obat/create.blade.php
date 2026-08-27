<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-4">
        <h2 class="text-2xl font-black text-slate-800 uppercase mb-8">Tambah Master Obat Baru</h2>

        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8">
            <form action="{{ route('master_obat.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Kode Obat</label>
                        <input type="text" name="kode_obat" required class="w-full bg-slate-50 border-none rounded-xl py-3 px-4">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Nama Obat</label>
                        <input type="text" name="nama_obat" required class="w-full bg-slate-50 border-none rounded-xl py-3 px-4">
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Golongan</label>
                        <select name="golongan" class="w-full bg-slate-50 border-none rounded-xl py-3 px-4">
                            <option value="Bebas">Bebas</option>
                            <option value="Bebas Terbatas">Bebas Terbatas</option>
                            <option value="Keras">Keras</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Satuan</label>
                        <input type="text" name="satuan" placeholder="Tablet/Botol" class="w-full bg-slate-50 border-none rounded-xl py-3 px-4">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Stok Minimal</label>
                        <input type="number" name="stok_minimal" value="10" class="w-full bg-slate-50 border-none rounded-xl py-3 px-4">
                    </div>
                </div>
                <button type="submit" class="bg-blue-600 text-white font-bold px-8 py-3 rounded-xl hover:bg-blue-700 transition">Simpan Katalog</button>
            </form>
        </div>
    </div>
</x-app-layout>