<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-4">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tighter">Riwayat Stok Keluar</h2>
                <p class="text-sm text-slate-500 italic">Log algoritma FIFO lintas batch secara sistematis.</p>
            </div>
            <a href="{{ route('stok_keluar.create') }}" class="bg-blue-600 text-white px-8 py-3.5 rounded-2xl font-black text-[10px] uppercase tracking-widest shadow-xl shadow-blue-200 hover:bg-blue-700 transition transform hover:-translate-y-1">
                + Catat Keluar Baru
            </a>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Waktu Log</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Nama Obat</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Kode Batch</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Qty</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Keterangan / Alur FIFO</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($stokKeluar as $item)
                        <tr class="hover:bg-blue-50/20 transition-colors group">
                            <td class="px-8 py-5 text-xs font-bold text-slate-500">{{ $item->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-8 py-5">
                                <span class="text-sm font-black text-slate-800 block">{{ $item->obat->masterObat->nama_obat }}</span>
                                <span class="text-[10px] text-slate-400 uppercase tracking-tighter">{{ $item->obat->masterObat->golongan }}</span>
                            </td>
                            <td class="px-8 py-5">
                                <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-black font-mono border border-blue-100">
                                    {{ $item->obat->batch }}
                                </span>
                            </td>
                            <td class="px-8 py-5 font-black text-slate-700">{{ $item->jumlah_keluar }} Unit</td>
                            <td class="px-8 py-5 text-[11px] text-slate-400 italic leading-relaxed">
                                {{ $item->keterangan }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center text-slate-300 font-bold italic">
                                <i class="fas fa-box-open text-4xl mb-4 block opacity-20"></i>
                                Belum ada data pengeluaran obat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-8">
            {{ $stokKeluar->links() }}
        </div>
    </div>
</x-app-layout>