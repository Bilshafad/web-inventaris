<!DOCTYPE html> <html> <head> <meta charset="utf-8"> <title>Laporan Barang</title> <style> body { font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #333; margin: 30px; }
    .kop-surat {
        display: flex;
        align-items: center;
        border-bottom: 2px solid #000;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .kop-surat img {
        width: 70px;
        height: 70px;
        margin-right: 15px;
    }

    .kop-text {
        text-align: center;
        flex-grow: 1;
    }

    .kop-text h1 {
        margin: 0;
        font-size: 18px;
        text-transform: uppercase;
    }

    .kop-text p {
        margin: 2px 0;
        font-size: 12px;
    }

    h2 {
        text-align: center;
        margin-bottom: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th, td {
        border: 1px solid #444;
        padding: 6px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    .footer {
        margin-top: 30px;
        text-align: right;
        font-size: 11px;
    }
</style>

</head> <body> <div class="kop-surat"> <img src="{{ public_path('logo-ut.png') }}" alt="Logo UT"> <div class="kop-text"> <h1>Universitas Terbuka Bandung</h1> <p>Jl. Raya Panyileukan No.1A, Cipadung Kidul, Kec. Panyileukan, Kota Bandung, Jawa Barat 40614</p> <p>Telp. 022-7801791 | Email: bandung@ecampus.ut.ac.id</p> </div> </div>
<h2>Laporan Inventaris Barang</h2>

<table>
    <thead>
        <tr>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Tanggal Pemeriksaan</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($barangs as $barang)
            <tr>
                <td>{{ $barang->kode_barang }}</td>
                <td>{{ $barang->nama_barang }}</td>
                <td>{{ \Carbon\Carbon::parse($barang->tanggal_pemeriksaan)->format('d M Y') }}</td>
                <td>{{ ucfirst($barang->status_barang) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">
    Dicetak pada: {{ now()->format('d M Y H:i') }}
</div>

</body> </html>