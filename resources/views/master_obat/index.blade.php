<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-4">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tighter">Katalog Master Obat</h2>
            <a href="{{ route('master_obat.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700 transition">
                + Tambah Jenis Obat
            </a>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-400">Kode</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-400">Nama Obat</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-400">Golongan</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-400">Satuan</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-400">Stok Min.</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-400">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($masterObats as $master)
                        <tr class="hover:bg-slate-50/50">
                            <td class="px-6 py-4 text-sm font-mono text-blue-600">{{ $master->kode_obat }}</td>
                            <td class="px-6 py-4 text-sm font-bold text-slate-800">{{ $master->nama_obat }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $master->golongan }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $master->satuan }}</td>
                            <td class="px-6 py-4 text-sm font-bold text-red-500">{{ $master->stok_minimal }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('master_obat.edit', $master->id) }}" class="text-blue-600 hover:underline">Edit</a>
                            </td>
                            <td>
                                    <form action="{{ route('master_obat.destroy', $master->id) }}" method="POST" onsubmit="return confirm('Sistem akan menghapus data master obat ini secara permanen. Lanjutkan?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-9 h-9 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-rose-500 hover:text-white transition shadow-sm" title="Hapus Data">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $masterObats->links() }}</div>
    </div>
</x-app-layout>