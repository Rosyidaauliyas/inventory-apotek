<!DOCTYPE html>
<html>
<head>
    <title>Laporan {{ ucwords(str_replace('_', ' ', $jenisLaporan)) }}</title>
    <style>
        body { font-family: sans-serif; font-size: 9pt; color: #333; line-height: 1.4; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; text-transform: uppercase; color: #1e40af; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #f1f5f9; border: 1px solid #ccc; padding: 10px; text-transform: uppercase; font-size: 7pt; color: #1e40af; }
        td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        .text-left { text-align: left; }
        .footer { margin-top: 40px; width: 100%; }
        .ttd { float: right; width: 200px; text-align: center; }
        .space { height: 70px; }
        .expired { color: #e11d48; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>UPTD PUSKESMAS TAROKAN</h2>
        <p>Jl. Raya Tarokan No. 123, Kediri</p>
        <p><strong>Laporan {{ ucwords(str_replace('_', ' ', $jenisLaporan)) }}</strong></p>
        <small>Periode: {{ date('d/m/Y', strtotime($tglMulai)) }} s/d {{ date('d/m/Y', strtotime($tglAkhir)) }}</small>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Nama Obat & Batch</th>
                @if($jenisLaporan == 'stok_keluar')
                    <th>Qty Keluar</th>
                    <th>Tanggal Keluar</th>
                @elseif($jenisLaporan == 'akurasi_stok')
                    <th>Sistem</th>
                    <th>Fisik</th>
                    <th>Selisih</th>
                @else
                    <th>Harga Satuan</th>
                    <th>Sisa Stok</th>
                    <th>Exp Date</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($data as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td class="text-left">
                    @php
                        // Logika sakti: Cek relasi MasterObat secara langsung atau lewat tabel transaksi
                        $nama = $item->masterObat->nama_obat ?? ($item->obat->masterObat->nama_obat ?? 'DATA TIDAK DITEMUKAN');
                        $batch = $item->batch ?? ($item->obat->batch ?? '-');
                    @endphp
                    <strong>{{ $nama }}</strong><br>
                    <small>Batch: {{ $batch }}</small>
                </td>
                @if($jenisLaporan == 'stok_keluar')
                    <td>{{ $item->jumlah_keluar }}</td>
                    <td>{{ date('d/m/Y', strtotime($item->tgl_keluar)) }}</td>
                @elseif($jenisLaporan == 'akurasi_stok')
                    <td>{{ $item->stok_sistem }}</td>
                    <td>{{ $item->stok_fisik }}</td>
                    <td>{{ ($item->selisih > 0 ? '+' : '').$item->selisih }}</td>
                @else
                    <td>Rp {{ number_format($item->harga ?? ($item->obat->harga ?? 0), 0, ',', '.') }}</td>
                    <td>{{ $item->stok }}</td>
                    <td class="expired">
                        {{ $item->tgl_kadaluarsa ? date('d/m/Y', strtotime($item->tgl_kadaluarsa)) : '-' }}
                    </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <div class="ttd">
            <p>Tarokan, {{ date('d F Y') }}</p>
            <p>Apoteker,</p>
            <div class="space"></div>
            <p><strong>( {{ auth()->user()->name }} )</strong></p>
            <p style="font-size: 7pt;">Petugas Inventori Farmasi</p>
        </div>
    </div>
</body>
</html>