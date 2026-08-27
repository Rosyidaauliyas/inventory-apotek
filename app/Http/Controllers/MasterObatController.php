<?php

namespace App\Http\Controllers;

use App\Models\MasterObat;
use Illuminate\Http\Request;

class MasterObatController extends Controller
{
    public function index()
    {
        $masterObats = MasterObat::latest()->paginate(10);
        return view('master_obat.index', compact('masterObats'));
    }

    public function create()
    {
        return view('master_obat.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_obat' => 'required|unique:master_obats,kode_obat',
            'nama_obat' => 'required',
            'golongan' => 'required',
            'satuan' => 'required',
            'stok_minimal' => 'required|integer',
        ]);

        MasterObat::create($validated);
        return redirect()->route('master_obat.index')->with('success', 'Katalog obat berhasil ditambah.');
    }

    public function edit(string $id)
    {
        // Mengambil data obat dengan ID spesifik
        $masterObat = MasterObat::findOrFail($id);
    
        // Menampilkan view edit dengan data tersebut
        return view('master_obat.edit', compact('masterObat'));
    }

    public function update(Request $request, string $id)
    {
            // Validasi input agar data tetap konsisten 
    $validated = $request->validate([
        'nama_obat' => 'required|string|max:255',
        'golongan'  => 'required|string',
        'satuan'    => 'required|string',
        'stok_minimal' => 'required|numeric|min:0',
    ]);

    try {
        $masterObat = MasterObat::findOrFail($id);
        $masterObat->update($validated);

        // Redirect kembali ke index dengan notifikasi sukses
        return redirect()->route('master_obat.index')
                         ->with('success', 'Data Master Obat berhasil diperbarui.');
    } catch (\Exception $e) {
        return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());

    public function destroy($id)
    {
        $masterObat = MasterObat::findOrfail($id);
        $masterObat->delete();

        return redirect()->route('master_obat.index')->with('success', 'Katalog obat berhasil dihapus.');
    }
}