<x-app-layout>
    <div class="space-y-8">
        <div>
            <nav class="flex text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3 gap-2">
                <span class="text-blue-600">Pengaturan</span>
                <span>/</span>
                <span>Profil Pengguna</span>
            </nav>
            <h1 class="text-4xl font-black text-slate-800 tracking-tight leading-none uppercase">Profil Saya</h1>
            <p class="text-sm text-slate-500 mt-3 font-medium">Kelola informasi akun dan keamanan kata sandi Anda.</p>
        </div>

        <div class="grid grid-cols-1 gap-8">
            
            <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden transition duration-300 hover:shadow-blue-100/30">
                <div class="p-8 sm:p-10">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden transition duration-300 hover:shadow-amber-100/30">
                <div class="p-8 sm:p-10">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden transition duration-300 hover:shadow-rose-100/30">
                <div class="p-8 sm:p-10 border-l-4 border-rose-500">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>