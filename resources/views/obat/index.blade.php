<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
            <div>
                <nav class="flex text-[10px] font-black uppercase tracking-[0.2em] text-blue-500 mb-2">
                    <span>Inventory</span>
                    <span class="mx-2 text-slate-300">/</span>
                    <span class="text-slate-400">Manajemen Stok Obat</span>
                </nav>
                <h2 class="text-4xl font-black text-slate-800 tracking-tighter uppercase leading-none">Daftar Inventori</h2>
                <p class="text-sm text-slate-500 mt-2 font-medium">Monitoring ketersediaan farmasi <span class="text-blue-600 font-bold italic">Puskesmas Tarokan</span></p>
            </div>
            
            <div class="flex items-center gap-4">
                <form action="{{ route('obat.index') }}" method="GET" class="relative group">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="CARI NAMA ATAU BATCH..." 
                           class="pl-11 pr-6 py-3.5 bg-white border-none rounded-2xl shadow-sm text-[10px] font-black tracking-widest text-slate-700 focus:ring-4 focus:ring-blue-500/10 transition-all w-64 uppercase border border-slate-100">
                </form>

                <a href="{{ route('obat.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-2xl font-black text-[10px] shadow-xl shadow-blue-200 transition transform hover:-translate-y-1 flex items-center gap-3 uppercase tracking-widest">
                    <i class="fas fa-plus"></i> Tambah Obat
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 text-xs font-bold rounded-r-xl shadow-sm">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-[3rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100 text-[10px] font-black uppercase tracking-widest text-slate-400">
                            <th class="px-10 py-8">Informasi Obat</th>
                            <th class="px-6 py-8 text-center">No. Batch</th>
                            <th class="px-6 py-8 text-center">Stok Fisik</th>
                            <th class="px-6 py-8 text-center">Status (EWS)</th>
                            <th class="px-10 py-8 text-right">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($semuaObat as $item)
                        <tr class="hover:bg-slate-50/50 transition duration-200 group">
                            <td class="px-10 py-6">
                                <div class="flex items-center gap-5">
                                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-500 flex items-center justify-center shadow-inner group-hover:scale-110 transition-transform">
                                        <i class="fas fa-capsules text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-800 leading-none">{{ $item->masterObat->nama_obat }}</p>
                                        <div class="flex items-center gap-2 mt-1.5">
                                            <span class="text-[9px] font-black text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md uppercase tracking-tighter">{{ $item->masterObat->kode_obat }}</span>
                                            <span class="text-[9px] font-bold text-slate-400 italic">| {{ $item->masterObat->golongan }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-6 text-center">
                                <span class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-[10px] font-black tracking-widest border border-slate-200 uppercase">{{ $item->batch }}</span>
                            </td>

                            <td class="px-6 py-6 text-center">
                            {{-- Di sini angkanya dibuat netral (slate-800) --}}
                                <p class="text-lg font-black text-slate-800 leading-none">
                                {{ $item->stok }}
                                </p>
                                <p class="text-[9px] text-slate-400 font-black uppercase mt-1 tracking-widest">
                                    {{ $item->masterObat->satuan }}
                                </p>
                            </td>

                            <td class="px-6 py-6 text-center">
                                @php
                                    // Penentuan Status Berdasarkan Hirarki Kontrol Stok
                                    if ($item->stok <= 0) {
                                        $label = 'HABIS';
                                        $style = 'bg-rose-50 text-rose-600 border-rose-100';
                                    } elseif ($item->tgl_kadaluarsa <= now()) {
                                        $label = 'KADALUARSA';
                                        $style = 'bg-rose-50 text-rose-600 border-rose-100';
                                    } elseif ($item->tgl_kadaluarsa <= now()->addMonths(6)) {
                                        $label = 'HAMPIR EXP';
                                        $style = 'bg-amber-50 text-amber-600 border-amber-100';
                                    } else {
                                        $label = 'TERSEDIA';
                                        $style = 'bg-emerald-50 text-emerald-600 border-emerald-100';
                                    }
                                @endphp
                                <span class="inline-flex items-center gap-2 py-1.5 px-4 rounded-full text-[9px] font-black uppercase tracking-widest border {{ $style }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current animate-pulse"></span>
                                    {{ $label }}
                                </span>
                            </td>

                            <td class="px-10 py-6 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('obat.edit', $item->id) }}" class="w-9 h-9 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-blue-500 hover:text-white transition shadow-sm" title="Edit Data">
                                        <i class="fas fa-edit text-xs"></i>
                                    </a>
                                    <form action="{{ route('obat.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Sistem akan menghapus data batch ini secara permanen. Lanjutkan?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-9 h-9 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-rose-500 hover:text-white transition shadow-sm" title="Hapus Data">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-10 py-20 text-center">
                                <div class="opacity-30">
                                    <i class="fas fa-box-open text-6xl mb-4 block text-slate-300"></i>
                                    <p class="text-slate-400 font-black uppercase text-[10px] tracking-[0.3em]">Data Inventori Kosong</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8">
            {{ $semuaObat->links() }}
        </div>
    </div>
</x-app-layout>