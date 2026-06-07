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
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 15px;
        }

        .header h1 {
            color: #667eea;
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
            color: #667eea;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table thead {
            background-color: #667eea;
            color: white;
        }

        table th {
            padding: 12px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #ddd;
        }

        table td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        table tbody tr:hover {
            background-color: #e8eaf6;
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
            font-size: 12px;
            font-weight: bold;
            text-align: center;
        }

        .badge-aktif {
            background-color: #28a745;
            color: white;
        }

        .badge-cuti {
            background-color: #ffc107;
            color: #333;
        }

        .badge-resign {
            background-color: #dc3545;
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
                <strong>Total Pegawai:</strong> {{ count($cetak) }}
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
                        <th style="width: 5%;">No</th>
                        <th style="width: 20%;">Nama</th>
                        <th style="width: 18%;">Email</th>
                        <th style="width: 15%;">Jabatan</th>
                        <th style="width: 15%;">Departemen</th>
                        <th style="width: 12%;">Status</th>
                        <th style="width: 15%;">Tanggal Masuk</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cetak as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $item->nama }}</strong></td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->jabatan }}</td>
                            <td>{{ $item->departemen }}</td>
                            <td>
                                @if ($item->status_pegawai == 'aktif')
                                    <span class="badge badge-aktif">Aktif</span>
                                @elseif($item->status_pegawai == 'cuti')
                                    <span class="badge badge-cuti">Cuti</span>
                                @else
                                    <span class="badge badge-resign">Resign</span>
                                @endif
                            </td>
                            <td>{{ $item->tanggal_masuk->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">
                <p><i class="mdi mdi-information-outline" style="font-size: 3rem; color: #ccc;"></i></p>
                <p>Tidak ada data pegawai untuk periode ini</p>
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
