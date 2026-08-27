<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Inventori Obat - Puskesmas Tarokan</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-900">
    <div class="relative min-h-screen flex flex-col">
        
        <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-600 p-2.5 rounded-xl shadow-lg shadow-blue-200 text-white transform -rotate-3">
                        <i class="fas fa-shield-halved text-xl"></i>
                    </div>
                    <div>
                        <span class="block font-black text-slate-800 leading-none tracking-tight uppercase">UPTD Puskesmas</span>
                        <span class="text-[10px] font-bold text-blue-600 tracking-[0.2em] uppercase">Tarokan Kediri</span>
                    </div>
                </div>

                @if (Route::has('login'))
                    <div class="flex items-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl font-bold text-sm shadow-xl shadow-blue-100 hover:bg-blue-700 transition transform hover:-translate-y-0.5">
                                KE DASHBOARD
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-6 py-2.5 bg-white text-blue-600 border-2 border-blue-600 rounded-xl font-bold text-sm hover:bg-blue-50 transition transform hover:-translate-y-0.5 flex items-center gap-2">
                                <i class="fas fa-sign-in-alt text-xs"></i> MASUK SISTEM
                            </a>
                        @endauth
                    </div>
                @endif
            </div>
        </nav>

        <main class="flex-1 flex flex-col items-center justify-center px-6 py-20 text-center relative overflow-hidden">
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-100/50 rounded-full blur-3xl opacity-50"></div>
            <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-sky-100/50 rounded-full blur-3xl opacity-50"></div>

            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-50 text-blue-700 border border-blue-100 mb-8 animate-pulse">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-600"></span>
                    </span>
                    <span class="text-[10px] font-black uppercase tracking-widest leading-none">Internal Access Only</span>
                </div>

                <h1 class="text-5xl md:text-7xl font-black text-slate-900 leading-[1.1] tracking-tight mb-6">
                    Akurasi Stok Obat<br>
                    <span class="text-blue-600">Metode FIFO Digital</span>
                </h1>

                <p class="max-w-2xl mx-auto text-lg text-slate-500 mb-12 leading-relaxed">
                    Sistem pemantauan persediaan farmasi pelayanan di UPTD Puskesmas Tarokan.
                </p>

                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                    <a href="{{ route('login') }}" class="group px-10 py-5 bg-slate-900 text-white rounded-2xl font-bold text-lg shadow-2xl shadow-slate-200 hover:bg-slate-800 transition transform hover:-translate-y-1 flex items-center gap-3">
                        Mulai Kelola Stok
                        <i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-24 max-w-5xl mx-auto">
                    <div class="p-8 bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-50 text-left group hover:scale-105 transition duration-300">
                        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-6">
                            <i class="fas fa-box-open text-xl"></i>
                        </div>
                        <h3 class="font-black text-slate-800 uppercase tracking-tight mb-2 text-sm text-center">Monitoring Stok</h3>
                        <p class="text-xs text-slate-500 leading-relaxed text-center">Pantau sisa obat secara real-time dengan notifikasi stok kritis otomatis.</p>
                    </div>
                    <div class="p-8 bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-blue-100 text-left group hover:scale-105 transition duration-300">
                        <div class="w-12 h-12 bg-blue-600 text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-blue-100">
                            <i class="fas fa-history text-xl"></i>
                        </div>
                        <h3 class="font-black text-slate-800 uppercase tracking-tight mb-2 text-sm text-center font-extrabold">Logika FIFO</h3>
                        <p class="text-xs text-slate-500 leading-relaxed text-center">Menjamin perputaran obat yang sehat berdasarkan tanggal kedaluwarsa terawal.</p>
                    </div>
                    <div class="p-8 bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-50 text-left group hover:scale-105 transition duration-300 text-center">
                        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-6 mx-auto">
                            <i class="fas fa-file-invoice text-xl"></i>
                        </div>
                        <h3 class="font-black text-slate-800 uppercase tracking-tight mb-2 text-sm text-center">Laporan Akurat</h3>
                        <p class="text-xs text-slate-500 leading-relaxed text-center">Hasil rekapulasi data harian dan bulanan yang siap digunakan untuk pelaporan.</p>
                    </div>
                </div>
            </div>
        </main>

        <footer class="py-12 bg-white border-t border-slate-100">
            <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="text-center md:text-left">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">&copy; 2026 Tugas Akhir MI UNESA</p>
                    <p class="text-sm font-black text-slate-800 uppercase italic leading-none">Rosyida Salsabila. <span class="text-blue-600 ml-2">22091397104</span></p>
                </div>
                <div class="flex items-center gap-8">
                    <img src="https://upload.wikimedia.org/wikipedia/id/thumb/d/d4/Logo_Unesa.png/800px-Logo_Unesa.png" alt="UNESA" class="h-10 grayscale hover:grayscale-0 transition opacity-50 hover:opacity-100">
                </div>
            </div>
        </footer>
    </div>
</body>
</html>