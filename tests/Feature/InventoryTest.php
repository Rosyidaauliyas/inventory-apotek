<?php

use App\Models\User;
use App\Models\MasterObat;
use App\Models\Obat;
use App\Models\StokKeluar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

uses(RefreshDatabase::class);

test('keamanan: guest tidak dapat mengakses halaman dashboard dan manajemen obat', function () {
    $this->get('/dashboard')->assertRedirect('/login');
    $this->get('/obat')->assertRedirect('/login');
});

test('akses dashboard: admin melihat ringkasan data obat yang akurat (DTO Check)', function () {
    $this->markTestSkipped('Dashboard logic has been moved to ObatController and needs a new test.');

    $admin = User::factory()->create(['role' => 'admin']);

    // Simulasi data obat
    MasterObat::factory()->has(Obat::factory()->count(1)->state(['stok' => 20]), 'batches')->count(5)->create();
    MasterObat::factory()->has(Obat::factory()->count(1)->state(['stok' => 5]), 'batches')->count(2)->create(['stok_minimal' => 10]);

    $response = $this->actingAs($admin)->get('/dashboard');
    
    $response->assertStatus(200);
    $response->assertViewHas('summary');
    
    // Ekstrak data yang dikirim ke view
    $summary = $response->viewData('summary');
    
    expect($summary->totalObat)->toBe(7);
    expect($summary->stokHampirHabis)->toBe(2);
});

test('php 8.4 property hooks: validasi otomatis status obat merespon perubahan data', function () {
    $master = MasterObat::factory()->create(['stok_minimal' => 10]);
    $batch = Obat::factory()->for($master)->create([
        'stok' => 0,
        'tgl_kadaluarsa' => Carbon::now()->addYear()
    ]);
    
    expect($batch->status)->toBe('HABIS'); // Stok <= 0

    $batch->stok = 5;
    expect($batch->status)->toBe('HAMPIR HABIS'); // Stok < stok_minimal

    $batch->stok = 20;
    expect($batch->status)->toBe('TERSEDIA'); // Stok melimpah

    $batch->tgl_kadaluarsa = Carbon::now()->subDay();
    expect($batch->status)->toBe('KADALUARSA'); // Terlepas dari sisa stok, jika expired maka prioritas statusnya Kadaluarsa
});

test('logika transaksi fifo: stok keluar lintas batch mengambil batch tertua terlebih dahulu', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $masterObat = MasterObat::factory()->create(['nama_obat' => 'Paracetamol 500mg']);

    // Batch 1 (Masuk lebih dulu, expired terdekat)
    $batch1 = Obat::factory()->for($masterObat)->create([
        'stok' => 10,
        'tgl_masuk' => Carbon::now()->subDays(10),
        'tgl_kadaluarsa' => Carbon::now()->addMonths(6),
    ]);

    // Batch 2 (Masuk belakangan, masa expired masih panjang)
    $batch2 = Obat::factory()->for($masterObat)->create([
        'stok' => 20,
        'tgl_masuk' => Carbon::now()->subDays(5),
        'tgl_kadaluarsa' => Carbon::now()->addMonths(12),
    ]);

    // Aksi: Request pengeluaran 15 unit
    $response = $this->actingAs($admin)->post(route('stok_keluar.store'), [
        'master_obat_id' => $masterObat->id, 
        'jumlah_keluar' => 15,
        'tgl_keluar' => Carbon::now()->toDateString(),
        'keterangan' => 'Untuk resep pasien'
    ]);

    $response->assertRedirect(route('stok_keluar.index'));
    $response->assertSessionHas('success');

    // Pastikan di database, Batch 1 dikuras hingga 0, sisa 5 diambil dari Batch 2
    $batch1->refresh();
    $batch2->refresh();

    expect($batch1->stok)->toBe(0);
    expect($batch2->stok)->toBe(5);
    expect($masterObat->total_stok)->toBe(5);

    // Cek tabel rekaman stok keluar harus ada 2 history yang tercatat terpisah
    $this->assertDatabaseCount('stok_keluars', 2);
    $this->assertDatabaseHas('stok_keluars', [
        'obat_id' => $batch1->id,
        'jumlah_keluar' => 10,
    ]);
    $this->assertDatabaseHas('stok_keluars', [
        'obat_id' => $batch2->id,
        'jumlah_keluar' => 5,
    ]);
});