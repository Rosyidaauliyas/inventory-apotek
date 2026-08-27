<x-app-layout>
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('users.index') }}" class="bg-white p-2 rounded-xl shadow-sm text-slate-400 hover:text-blue-600 transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Tambah Personil Baru</h2>
            <p class="text-slate-500 text-sm">Daun petugas atau admin baru untuk akses sistem Puskesmas.</p>
        </div>
    </div>

    <div class="max-w-2xl bg-white rounded-3xl shadow-xl shadow-slate-200/50 overflow-hidden">
        <form action="{{ route('users.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            
            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2">Nama Lengkap</label>
                <input type="text" name="name" required placeholder="Masukkan nama petugas..." 
                    class="w-full px-4 py-3 rounded-xl border-slate-200 bg-slate-50 focus:border-blue-500 focus:ring-blue-500 transition">
            </div>

            <div>
                <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2">Alamat Email</label>
                <input type="email" name="email" required placeholder="nama@gmail.com" 
                    class="w-full px-4 py-3 rounded-xl border-slate-200 bg-slate-50 focus:border-blue-500 focus:ring-blue-500 transition">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2">Password Akses</label>
                    <input type="password" name="password" required placeholder="Minimal 8 karakter..." 
                        class="w-full px-4 py-3 rounded-xl border-slate-200 bg-slate-50 focus:border-blue-500 focus:ring-blue-500 transition">
                </div>

                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2">Otoritas (Role)</label>
                    <select name="role" required class="w-full px-4 py-3 rounded-xl border-slate-200 bg-slate-50 focus:border-blue-500 focus:ring-blue-500 transition">
                        <option value="petugas">Petugas Apotek</option>
                        <option value="admin">Administrator</option>
                        <option value="kepala">Kepala Puskesmas</option>
                    </select>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-bold shadow-lg shadow-blue-200 hover:bg-blue-700 transition flex items-center justify-center gap-2">
                    <i class="fas fa-user-plus text-sm"></i>
                    Simpan Data Personil
                </button>
            </div>
        </form>
    </div>
</x-app-layout>