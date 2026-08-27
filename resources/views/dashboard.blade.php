<x-app-layout>
    <div class="space-y-10">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                {{-- Sapaan dinamis sesuai Role dan Nama --}}
                <h2 class="text-3xl font-black text-slate-800 tracking-tight leading-none uppercase">
                    Selamat Datang, 
                    @if(auth()->user()->role == 'kepala')
                        Kepala Puskesmas!
                    @else
                        {{ auth()->user()->name }}!
                    @endif
                </h2>
                <p class="text-sm text-slate-500 mt-2 font-medium italic">
                    {{ now()->translatedFormat('l, d F Y') }} — 
                    <span class="text-blue-600 font-bold uppercase not-italic">
                        Login Sebagai: {{ auth()->user()->role == 'kepala' ? 'Kepala Puskesmas' : auth()->user()->role }}
                    </span>
                </p>
            </div>
            
            {{-- Tombol hanya muncul jika bukan Kepala Puskesmas (Admin & Petugas bisa akses) --}}
            @if(auth()->user()->role !== 'kepala')
            <div class="flex gap-3">
                <a href="{{ route('obat.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-black text-[10px] shadow-xl shadow-blue-200 transition transform hover:-translate-y-1 flex items-center gap-2 uppercase tracking-widest">
                    <i class="fas fa-plus"></i> Input Stok Masuk
                </a>
                <a href="{{ route('stok_keluar.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-2xl font-black text-[10px] shadow-xl shadow-emerald-200 transition transform hover:-translate-y-1 flex items-center gap-2 uppercase tracking-widest">
                    <i class="fas fa-sign-out-alt"></i> Input Stok Keluar
                </a>
            </div>
            @endif
        </div>

        {{-- STATS CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/50 border border-slate-100 p-8 flex items-center transition duration-300 hover:shadow-blue-100/50">
                <div class="w-16 h-16 rounded-[1.5rem] bg-blue-50 text-blue-600 flex items-center justify-center mr-6 shadow-inner">
                    <i class="fas fa-pills text-2xl"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Total Jenis Obat</p>
                    <p class="text-4xl font-black text-slate-800 leading-none">{{ $summary->totalObat }}</p>
                </div>
                <div class="ml-auto w-1 h-12 bg-blue-600 rounded-full opacity-20"></div>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/50 border border-slate-100 p-8 flex items-center transition duration-300 hover:shadow-orange-100/50">
                <div class="w-16 h-16 rounded-[1.5rem] bg-orange-50 text-orange-500 flex items-center justify-center mr-6 shadow-inner">
                    <i class="fas fa-clock text-2xl"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Hampir Kadaluarsa</p>
                    <p class="text-4xl font-black text-slate-800 leading-none">{{ $summary->hampirExp }}</p>
                </div>
                <div class="ml-auto w-1 h-12 bg-orange-500 rounded-full opacity-20"></div>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/60 border border-slate-100 p-8 flex items-center transition duration-300 hover:shadow-rose-100/50">
                <div class="w-16 h-16 rounded-[1.5rem] bg-rose-50 text-rose-500 flex items-center justify-center mr-6 shadow-inner">
                    <i class="fas fa-calendar-times text-2xl"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Batch Kadaluarsa</p>
                    <p class="text-4xl font-black text-slate-800 leading-none">{{ $summary->obatKadaluarsa }}</p>
                </div>
                <div class="ml-auto w-1 h-12 bg-rose-600 rounded-full opacity-20"></div>
            </div>
        </div>

        {{-- TABEL FIFO --}}
        <div class="space-y-4">
            <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.3em] ml-2">Ringkasan Stok Terbaru (FIFO)</h3>
            <div class="bg-white rounded-[3rem] shadow-2xl shadow-slate-200/60 border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-100 text-[10px] font-black uppercase tracking-widest text-slate-400">
                                <th class="px-10 py-6">Nama Obat</th>
                                <th class="px-6 py-6 text-center">Batch</th>
                                <th class="px-6 py-6 text-center">Kadaluarsa</th>
                                <th class="px-6 py-6 text-center">Harga/PCS</th>
                                <th class="px-6 py-6 text-center">Tersedia</th>
                                <th class="px-10 py-6 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($obats as $obat)
                            <tr class="hover:bg-slate-50/50 transition duration-150 group">
                                <td class="px-10 py-6">
                                    <p class="text-sm font-black text-slate-800 leading-none">{{ $obat->masterObat->nama_obat }}</p>
                                    <p class="text-[10px] text-blue-500 font-bold uppercase mt-1 tracking-tighter">{{ $obat->masterObat->kode_obat }}</p>
                                </td>
                                <td class="px-6 py-6 text-center">
                                    <span class="text-[10px] font-black text-slate-500 bg-slate-100 px-3 py-1 rounded-lg">{{ $obat->batch }}</span>
                                </td>
                                <td class="px-6 py-6 text-center text-xs font-bold {{ $obat->tgl_kadaluarsa <= now() ? 'text-rose-500 italic' : 'text-slate-600' }}">
                                    {{ \Carbon\Carbon::parse($obat->tgl_kadaluarsa)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-6 text-center text-xs font-bold text-slate-600 uppercase">
                                    Rp {{ number_format($obat->harga, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-6 text-center">
                                    <span class="text-sm font-black text-slate-800">{{ $obat->stok }}</span>
                                    <span class="text-[10px] text-slate-400 font-black ml-1 uppercase">{{ $obat->masterObat->satuan }}</span>
                                </td>
                                <td class="px-10 py-6 text-right">
                                    @php
                                        $statusColor = match($obat->status) {
                                            'TERSEDIA' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                            'HAMPIR HABIS' => 'bg-amber-50 text-amber-600 border-amber-100',
                                            'HAMPIR EXP' => 'bg-orange-50 text-orange-600 border-orange-100',
                                            'KADALUARSA', 'HABIS' => 'bg-rose-50 text-rose-600 border-rose-100',
                                            default => 'bg-slate-50 text-slate-600 border-slate-100',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center gap-2 py-1.5 px-4 rounded-full text-[9px] font-black uppercase tracking-widest border {{ $statusColor }}">
                                        {{ $obat->status }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>