<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventori Farmasi - UPTD Puskesmas Tarokan</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F1F5F9] font-sans antialiased text-slate-900" x-data="{ openProfile: false }">
    <div class="flex min-h-screen overflow-hidden">
        
        <aside class="w-72 bg-[#1E3A8A] text-white flex-shrink-0 shadow-2xl flex flex-col z-50">
            <div class="p-8 flex flex-col items-start gap-4 border-b border-white/10 bg-blue-900/20">
                <div class="bg-white p-3 rounded-2xl shadow-xl transform -rotate-6">
                    <i class="fas fa-prescription-bottle-alt text-2xl text-blue-800"></i>
                </div>
                <div>
                    <span class="text-lg font-black leading-none tracking-tighter uppercase block">Inventori</span>
                    <span class="text-[10px] font-bold text-blue-300 uppercase tracking-[0.3em]">Apotek Digital</span>
                </div>
            </div>
            
            <nav class="mt-8 px-4 space-y-1.5 flex-1 overflow-y-auto custom-scrollbar pb-10">
                <p class="px-5 text-[10px] font-black uppercase tracking-[0.2em] text-blue-300/40 mb-4">Navigasi Utama</p>
                
                <x-nav-link-custom href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" icon="fa-th-large">Dashboard</x-nav-link-custom>
                <x-nav-link-custom href="{{ route('obat.index') }}" :active="request()->routeIs('obat.index')" icon="fa-pills">Daftar Obat</x-nav-link-custom>
                
                {{-- REVISI: Stok Masuk & Keluar HANYA muncul jika BUKAN Kepala Puskesmas --}}
                @if(Auth::user()->role !== 'kepala')
                    <x-nav-link-custom href="{{ route('obat.create') }}" :active="request()->routeIs('obat.create')" icon="fa-arrow-down">Stok Masuk</x-nav-link-custom>
                    <x-nav-link-custom href="{{ route('stok_keluar.create') }}" :active="request()->routeIs('stok_keluar.*')" icon="fa-arrow-up">Stok Keluar</x-nav-link-custom>
                @endif

                <x-nav-link-custom href="{{ route('akurasi.index') }}" :active="request()->routeIs('akurasi.*')" icon="fa-check-double">Cek Akurasi</x-nav-link-custom>
                <x-nav-link-custom href="{{ route('laporan.index') }}" :active="request()->routeIs('laporan.*')" icon="fa-chart-pie">Laporan</x-nav-link-custom>

                @if(Auth::user()->role == 'admin')
                    <div class="pt-8 mt-8 border-t border-white/5">
                        <p class="px-5 text-[10px] font-black uppercase tracking-[0.2em] text-blue-300/40 mb-4">Administrator</p>
                        <x-nav-link-custom href="{{ route('users.index') }}" :active="request()->routeIs('users.*')" icon="fa-users-cog">Manajemen User</x-nav-link-custom>
                    </div>
                @endif
            </nav>
        </aside>

        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <header class="bg-white/80 backdrop-blur-md h-20 flex items-center justify-between px-10 border-b border-slate-200 sticky top-0 z-40">
                <div class="flex items-center">
                    <div class="flex items-center gap-2 px-4 py-2 bg-slate-100 rounded-full border border-slate-200">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-slate-600 font-black uppercase tracking-widest text-[9px]">UPTD Puskesmas Tarokan</span>
                    </div>
                </div>

                <div class="flex items-center gap-6">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-black text-slate-800 leading-none">{{ Auth::user()->name }}</p>
                        {{-- Tampilan Role --}}
                        <p class="text-[10px] text-blue-600 font-bold uppercase mt-1.5 tracking-widest">
                            {{ Auth::user()->role == 'kepala' ? 'Kepala Puskesmas' : Auth::user()->role }}
                        </p>
                    </div>
                    
                    <div class="relative">
                        <button @click="openProfile = ! openProfile" class="flex items-center focus:outline-none group">
                            <div class="relative">
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/'.Auth::user()->avatar) }}" class="h-11 w-11 rounded-2xl object-cover border-2 border-white shadow-lg transition group-hover:scale-105">
                                @else
                                    <div class="h-11 w-11 bg-blue-600 rounded-2xl flex items-center justify-center text-white text-sm font-black border-2 border-white shadow-lg group-hover:bg-blue-700 transition">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif
                                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 border-2 border-white rounded-full"></div>
                            </div>
                        </button>

                        <div x-show="openProfile" 
                             @click.away="openProfile = false" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-4"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="absolute right-0 mt-4 w-72 bg-white rounded-[2rem] shadow-2xl py-2 z-50 border border-slate-100 overflow-hidden">
                            
                            <div class="px-8 py-6 bg-slate-50 border-b border-slate-100 mb-2">
                                <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest">Login Sebagai</p>
                                <p class="text-[13px] text-slate-800 font-black truncate mt-1.5">{{ Auth::user()->email }}</p>
                            </div>

                            <div class="px-3 space-y-1">
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-4 px-5 py-3.5 text-xs font-black text-slate-600 hover:bg-blue-50 hover:text-blue-600 rounded-2xl transition group">
                                    <i class="fas fa-id-badge text-base opacity-40 group-hover:opacity-100"></i>
                                    <span>Pengaturan Profil</span>
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full gap-4 px-5 py-3.5 text-xs font-black text-rose-500 hover:bg-rose-50 rounded-2xl transition group">
                                        <i class="fas fa-power-off text-base opacity-40 group-hover:opacity-100"></i>
                                        <span>Keluar Sistem</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-12 bg-[#F8FAFC]">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>