<x-app-layout>
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Pemeriksaan Stok Fisik</h2>
                <p class="text-gray-500">Bandingkan jumlah di sistem dengan jumlah nyata di gudang</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-400">Tanggal Pemeriksaan:</p>
                <p class="font-bold text-blue-600">{{ date('d F Y') }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <form action="{{ route('akurasi.store') }}" method="POST">
                @csrf
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-4">Nama Obat</th>
                            <th class="px-6 py-4">No. Batch</th>
                            <th class="px-6 py-4 text-center">Stok Sistem</th>
                            <th class="px-6 py-4 text-center">Stok Fisik</th>
                            <th class="px-6 py-4 text-center">Selisih</th>
                            <th class="px-6 py-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($semuaObat as $obat)
                        <tr class="hover:bg-blue-50/30 transition">
                            <td class="px-6 py-4 font-bold text-gray-700">{{ $obat->nama_obat }}</td>
                            <td class="px-6 py-4 text-gray-500">{{ $obat->batch }}</td>
                            <td class="px-6 py-4 text-center font-bold text-blue-600" id="sistem-{{ $obat->id }}">{{ $obat->stok }}</td>
                            <td class="px-6 py-4 text-center">
                                <input type="number" name="stok_fisik[]" 
                                       class="stok-fisik w-24 text-center border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500" 
                                       data-id="{{ $obat->id }}" 
                                       placeholder="0">
                                <input type="hidden" name="obat_id[]" value="{{ $obat->id }}">
                            </td>
                            <td class="px-6 py-4 text-center font-bold" id="selisih-{{ $obat->id }}">0</td>
                            <td class="px-6 py-4 text-center">
                                <span id="status-{{ $obat->id }}" class="px-3 py-1 rounded-full text-[10px] font-bold bg-green-100 text-green-600">
                                    SESUAI
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="p-6 bg-gray-50 border-t flex justify-end gap-4">
                    <a href="{{ route('obat.index') }}" class="px-6 py-2 text-gray-600 font-bold hover:bg-gray-200 rounded-xl transition">Batal</a>
                    <button type="submit" class="px-8 py-2 bg-blue-600 text-white font-bold rounded-xl shadow-lg hover:bg-blue-700 transition">
                        Simpan Hasil Pemeriksaan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll('.stok-fisik').forEach(input => {
            input.addEventListener('input', function() {
                const id = this.getAttribute('data-id');
                const stokSistem = parseInt(document.getElementById('sistem-' + id).innerText);
                const stokFisik = parseInt(this.value) || 0;
                
                const selisih = stokFisik - stokSistem;
                const selisihEl = document.getElementById('selisih-' + id);
                const statusEl = document.getElementById('status-' + id);

                // Tampilkan angka selisih
                selisihEl.innerText = (selisih > 0 ? '+' : '') + selisih;

                // Logika Warna dan Status
                if (selisih === 0) {
                    selisihEl.className = "px-6 py-4 text-center font-bold text-gray-400";
                    statusEl.innerText = "SESUAI";
                    statusEl.className = "px-3 py-1 rounded-full text-[10px] font-bold bg-green-100 text-green-600";
                } else {
                    selisihEl.className = "px-6 py-4 text-center font-bold text-red-600";
                    statusEl.innerText = "TIDAK SESUAI";
                    statusEl.className = "px-3 py-1 rounded-full text-[10px] font-bold bg-red-100 text-red-600";
                }
            });
        });
    </script>
</x-app-layout>