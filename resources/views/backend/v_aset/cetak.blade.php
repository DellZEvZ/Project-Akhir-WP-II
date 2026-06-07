<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $judul }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #17a2b8;
            padding-bottom: 15px;
        }

        .header h1 {
            color: #17a2b8;
            font-size: 24px;
            margin-bottom: 5px;
        }

        .header p {
            color: #666;
            font-size: 14px;
        }

        .report-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .info-item {
            font-size: 13px;
        }

        .info-item strong {
            color: #17a2b8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table thead {
            background-color: #17a2b8;
            color: white;
        }

        table th {
            padding: 12px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #ddd;
            font-size: 13px;
        }

        table td {
            padding: 10px;
            border: 1px solid #ddd;
            font-size: 12px;
        }

        table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        table tbody tr:hover {
            background-color: #e0f7fa;
        }

        .no-data {
            text-align: center;
            padding: 30px;
            color: #999;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            text-align: center;
        }

        .badge-baik {
            background-color: #28a745;
            color: white;
        }

        .badge-rusak {
            background-color: #dc3545;
            color: white;
        }

        .badge-hilang {
            background-color: #ffc107;
            color: #333;
        }

        .badge-dijual {
            background-color: #6c757d;
            color: white;
        }

        @media print {
            body {
                background: white;
            }

            .no-print {
                display: none;
            }

            table {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>{{ $judul }}</h1>
            <p>CAREXIS - Care Excellence Information System</p>
        </div>

        <!-- Report Info -->
        <div class="report-info">
            <div class="info-item">
                <strong>Periode:</strong> {{ \Carbon\Carbon::parse($tanggalAwal)->format('d/m/Y') }} s/d {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d/m/Y') }}
            </div>
            <div class="info-item">
                <strong>Total Aset:</strong> {{ count($cetak) }}
            </div>
            <div class="info-item">
                <strong>Tanggal Cetak:</strong> {{ now()->format('d/m/Y H:i') }}
            </div>
        </div>

        <!-- Table -->
        @if (count($cetak) > 0)
            <table>
                <thead>
                    <tr>
                        <th style="width: 4%;">No</th>
                        <th style="width: 12%;">Kode Aset</th>
                        <th style="width: 16%;">Nama Aset</th>
                        <th style="width: 12%;">Kategori</th>
                        <th style="width: 12%;">Lokasi</th>
                        <th style="width: 12%;">Tanggal Beli</th>
                        <th style="width: 14%;">Harga Perolehan</th>
                        <th style="width: 10%;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cetak as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $item->kode_aset }}</strong></td>
                            <td>{{ $item->nama_aset }}</td>
                            <td>{{ $item->kategori }}</td>
                            <td>{{ $item->lokasi }}</td>
                            <td>{{ $item->tanggal_pembelian->format('d/m/Y') }}</td>
                            <td>Rp {{ number_format($item->harga_perolehan, 0, ',', '.') }}</td>
                            <td>
                                @if ($item->status_aset == 'baik')
                                    <span class="badge badge-baik">Baik</span>
                                @elseif($item->status_aset == 'rusak')
                                    <span class="badge badge-rusak">Rusak</span>
                                @elseif($item->status_aset == 'hilang')
                                    <span class="badge badge-hilang">Hilang</span>
                                @else
                                    <span class="badge badge-dijual">Dijual</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">
                <p><i class="mdi mdi-information-outline" style="font-size: 3rem; color: #ccc;"></i></p>
                <p>Tidak ada data aset untuk periode ini</p>
            </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>Laporan ini adalah dokumen resmi dari sistem CAREXIS</p>
            <p>Dicetak pada {{ now()->format('d F Y \p\u\k\u\l H:i:s') }}</p>
        </div>
    </div>

    <script>
        // Auto print on load
        window.print();
    </script>
</body>
</html>
