<x-app-layout>
    <div class="space-y-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <nav class="flex text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3 gap-2">
                    <span class="text-blue-600">Administrator</span>
                    <span>/</span>
                    <span>Manajemen Personil</span>
                </nav>
                <h1 class="text-4xl font-black text-slate-800 tracking-tight leading-none">Akses Pengguna</h1>
                <p class="text-sm text-slate-500 mt-3 font-medium">Kelola hak akses <span class="text-blue-600 font-bold italic">Admin & Petugas Apotek</span></p>
            </div>
            
            <a href="{{ route('users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-2xl font-black text-xs shadow-2xl shadow-blue-200 transition transform hover:-translate-y-1 flex items-center justify-center gap-3 uppercase tracking-widest">
                <i class="fas fa-user-plus"></i>
                <span>Tambah Personil</span>
            </a>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/60 border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100">
                            <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Nama Lengkap</th>
                            <th class="px-6 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Alamat Email</th>
                            <th class="px-6 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 text-center">Otoritas (Role)</th>
                            <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 text-right">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($users as $user)
                        <tr class="hover:bg-blue-50/40 transition duration-150 group">
                            <td class="px-10 py-7">
                                <div class="flex items-center gap-5">
                                    <div class="w-12 h-12 bg-blue-600 text-white rounded-2xl flex items-center justify-center font-black text-sm shadow-lg shadow-blue-100 uppercase transition duration-300">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-800 mb-0.5 leading-none">{{ $user->name }}</p>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Anggota Aktif</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-7">
                                <p class="text-sm font-bold text-slate-600 italic">{{ $user->email }}</p>
                            </td>
                            <td class="px-6 py-7 text-center">
                                @php
                                    $roleStyle = match($user->role) {
                                        'admin' => 'bg-purple-50 text-purple-600 border-purple-100',
                                        'kepala' => 'bg-amber-50 text-amber-600 border-amber-100',
                                        default => 'bg-blue-50 text-blue-600 border-blue-100',
                                    };
                                @endphp
                                <span class="inline-flex items-center gap-2 py-2 px-5 rounded-full text-[9px] font-black uppercase tracking-[0.15em] border shadow-sm {{ $roleStyle }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-10 py-7 text-right">
                                <div class="flex justify-end gap-2">
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user {{ $user->name }}?')" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-10 h-10 flex items-center justify-center bg-slate-50 text-rose-400 rounded-xl hover:bg-rose-500 hover:text-white transition shadow-sm border border-slate-100">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>