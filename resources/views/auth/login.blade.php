<x-guest-layout>
    <div class="mb-8 text-center">
        <div class="inline-flex p-4 rounded-3xl bg-blue-50 text-blue-600 mb-4 shadow-sm border border-blue-100">
            <i class="fas fa-prescription-bottle-alt text-3xl"></i>
        </div>
        <h2 class="text-2xl font-black text-slate-800 tracking-tight leading-none">Masuk Sistem</h2>
        <p class="text-[11px] text-slate-500 mt-3 uppercase tracking-widest font-bold">
            Inventori Obat <span class="text-blue-600">Puskesmas Tarokan</span>
        </p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf
        <div>
            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2 ml-1">Email Petugas</label>
            <input type="email" name="email" :value="old('email')" required autofocus 
                class="w-full px-5 py-4 rounded-2xl border-slate-100 bg-slate-50 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm placeholder:text-slate-300" placeholder="nama@gmail.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2 ml-1">Kata Sandi</label>
            <input type="password" name="password" required 
                class="w-full px-5 py-4 rounded-2xl border-slate-100 bg-slate-50 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm placeholder:text-slate-300" placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center px-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded-lg border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                <span class="ms-2 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Ingat Saya</span>
            </label>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-bold shadow-xl shadow-blue-100 hover:bg-blue-700 transition transform hover:-translate-y-0.5 active:scale-95">
            MASUK SEKARANG
        </button>
    </form>
</x-guest-layout>