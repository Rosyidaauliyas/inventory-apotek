<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\MasterObatController;
use App\Http\Controllers\StokKeluarController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route; 

// 1. LANDING PAGE
Route::get('/', function () {
    return view('welcome');
});

// 2. AKSES BERSAMA (Admin, Kepala, & Petugas)
// Dashboard, Daftar Obat, Laporan, dan Cek Akurasi sekarang bisa diakses SEMUA ROLE
Route::middleware(['auth', 'verified', 'role:admin,kepala,petugas'])->group(function () {
    Route::get('/dashboard', [ObatController::class, 'indexDashboard'])->name('dashboard');
    
    // Daftar Obat
    Route::get('/obat', [ObatController::class, 'index'])->name('obat.index');
    
    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetakPdf'])->name('laporan.cetak_pdf');

    // Pindahkan ke sini agar Kepala Puskesmas tidak kena 403 lagi
    Route::get('/akurasi-stok', [ObatController::class, 'indexAkurasi'])->name('akurasi.index');
    Route::post('/akurasi-stok/simpan', [ObatController::class, 'storeAkurasi'])->name('akurasi.store');
});

// 3. AKSES OPERASIONAL (Admin & Petugas)
// Aksi Input/Edit/Hapus stok tetap dibatasi untuk Kepala sesuai aturan
Route::middleware(['auth', 'role:admin,petugas'])->group(function () {
    
    // Inventory / Stok Masuk (Kecuali index yang sudah ada di atas)
    Route::resource('obat', ObatController::class)->except(['index']);

    // Stok Keluar
    Route::get('/stok-keluar', [StokKeluarController::class, 'index'])->name('stok_keluar.index');
    Route::get('/stok-keluar/tambah', [StokKeluarController::class, 'create'])->name('stok_keluar.create');
    Route::post('/stok-keluar/simpan', [StokKeluarController::class, 'store'])->name('stok_keluar.store');
});

// 4. AKSES KHUSUS ADMIN (Master Data)
Route::middleware(['auth', 'role:admin,petugas'])->group(function () {
    Route::resource('master-obat', MasterObatController::class)->names('master_obat');
    Route::resource('users', UserController::class);
});

// 5. AKSES UMUM (Semua yang Login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';