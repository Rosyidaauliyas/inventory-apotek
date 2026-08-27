<nav x-data="{ open: false }" class="bg-white border-b border-slate-100 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <x-application-logo class="block h-8 w-auto fill-current text-blue-600" />
                        <span class="font-black text-slate-800 tracking-tighter text-lg uppercase">Inventori<span class="text-blue-600">Apotek</span></span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="font-bold text-xs uppercase tracking-widest">
                        Dashboard
                    </x-nav-link>

                    {{-- Stok Masuk & Keluar hanya untuk Admin dan Petugas --}}
                    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'petugas')
                        <x-nav-link :href="route('obat.create')" :active="request()->routeIs('obat.create')" class="font-bold text-xs uppercase tracking-widest">
                            Stok Masuk
                        </x-nav-link>
                        <x-nav-link :href="route('stok_keluar.create')" :active="request()->routeIs('stok_keluar.create')" class="font-bold text-xs uppercase tracking-widest">
                            Stok Keluar
                        </x-nav-link>
                    @endif

                    {{-- Cek Akurasi: Admin dan Kepala Puskesmas --}}
                    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'kepala')
                        <x-nav-link :href="route('akurasi.index')" :active="request()->routeIs('akurasi.index')" class="font-bold text-xs uppercase tracking-widest">
                            Cek Akurasi
                        </x-nav-link>
                    @endif

                    <x-nav-link :href="route('laporan.index')" :active="request()->routeIs('laporan.index')" class="font-bold text-xs uppercase tracking-widest">
                        Laporan
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-slate-100 text-sm leading-4 font-medium rounded-2xl text-slate-500 bg-slate-50 hover:bg-white hover:text-slate-700 focus:outline-none transition ease-in-out duration-150 shadow-sm">
                            <div class="flex flex-col items-end mr-3">
                                <span class="font-black text-slate-800 text-xs uppercase tracking-tighter">{{ Auth::user()->name }}</span>
                                <span class="text-[9px] font-black uppercase px-2 bg-blue-600 text-white rounded-lg">
                                    {{ Auth::user()->role == 'kepala' ? 'Kepala Puskesmas' : Auth::user()->role }}
                                </span>
                            </div>

                            <div class="ms-1 text-slate-400">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-2 border-b border-slate-50">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Opsi Pengguna</p>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')" class="font-bold text-xs uppercase py-3">
                            Pengaturan Profil
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    class="font-bold text-xs uppercase py-3 text-rose-600"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-400 hover:text-slate-500 hover:bg-slate-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- RESPONSIVE MENU (MOBILE) --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-slate-50">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="font-bold uppercase text-xs">
                Dashboard
            </x-responsive-nav-link>

            {{-- Stok Masuk & Keluar HANYA untuk Admin dan Petugas (Mobile) --}}
            @if(Auth::user()->role == 'admin' || Auth::user()->role == 'petugas')
                <x-responsive-nav-link :href="route('obat.create')" :active="request()->routeIs('obat.create')" class="font-bold uppercase text-xs">
                    Stok Masuk
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('stok_keluar.create')" :active="request()->routeIs('stok_keluar.create')" class="font-bold uppercase text-xs">
                    Stok Keluar
                </x-responsive-nav-link>
            @endif

            {{-- Cek Akurasi: Admin dan Kepala (Mobile) --}}
            @if(Auth::user()->role == 'admin' || Auth::user()->role == 'kepala')
                <x-responsive-nav-link :href="route('akurasi.index')" :active="request()->routeIs('akurasi.index')" class="font-bold uppercase text-xs">
                    Cek Akurasi
                </x-responsive-nav-link>
            @endif

            <x-responsive-nav-link :href="route('laporan.index')" :active="request()->routeIs('laporan.index')" class="font-bold uppercase text-xs">
                Laporan
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-slate-100">
            <div class="px-4 flex items-center justify-between">
                <div>
                    <div class="font-black text-sm text-slate-800 uppercase tracking-tighter">{{ Auth::user()->name }}</div>
                    <div class="font-bold text-[10px] text-blue-600 uppercase">{{ Auth::user()->role == 'kepala' ? 'Kepala Puskesmas' : Auth::user()->role }}</div>
                </div>
                <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center text-slate-400">
                    <i class="fas fa-user text-xs"></i>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="font-bold uppercase text-[10px]">
                    Profil Saya
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            class="font-bold uppercase text-[10px] text-rose-600"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        Log Out
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>