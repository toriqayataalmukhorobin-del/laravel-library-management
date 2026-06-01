<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman Perpustakaan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0 0 10px 0;
            font-size: 24px;
        }
        .header p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }
        .info {
            margin-bottom: 20px;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px 12px;
            text-align: left;
            font-size: 12px;
        }
        th {
            background-color: #f4f4f4;
            font-weight: 600;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
            font-size: 14px;
        }
        .footer p {
            margin: 0 0 60px 0;
        }
        @media print {
            body {
                padding: 0;
                margin: 2cm;
            }
            .no-print {
                display: none;
            }
        }
        .btn-print {
            display: inline-block;
            background-color: #4299e1;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            margin-bottom: 20px;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <div class="no-print" style="text-align: right;">
        <button onclick="window.print()" class="btn-print">Cetak Laporan</button>
        <a href="{{ route('borrowings.index') }}" style="margin-left: 10px; color: #666;">Kembali</a>
    </div>

    <div class="header">
        <h1>Laporan Peminjaman PerpustakaanKU</h1>
        <p>Data Riwayat Peminjaman Buku Keseluruhan</p>
    </div>

    <div class="info">
        <table style="border: none; margin-bottom: 0;">
            <tr>
                <td style="border: none; padding: 0 0 5px 0; width: 120px;"><strong>Tanggal Cetak</strong></td>
                <td style="border: none; padding: 0 0 5px 0;">: {{ $date }}</td>
            </tr>
            <tr>
                <td style="border: none; padding: 0;"><strong>Filter Data</strong></td>
                <td style="border: none; padding: 0;">: {{ ucfirst($filter) }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th>Peminjam</th>
                <th>Judul Buku</th>
                <th>Tgl Pinjam</th>
                <th>Batas Kembali</th>
                <th class="text-center">Tipe</th>
                <th class="text-center">Status</th>
                <th class="text-right">Denda</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($borrowings as $index => $borrowing)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $borrowing->borrower_display_name }}</td>
                <td>{{ $borrowing->book->title ?? 'Buku Dihapus' }}</td>
                <td>{{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('d M Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($borrowing->return_date)->format('d M Y') }}</td>
                <td class="text-center">
                    {{ ucfirst($borrowing->type) }}
                </td>
                <td class="text-center">
                    {{ $borrowing->status == 'borrowed' ? 'Dipinjam' : 'Dikembalikan' }}
                </td>
                <td class="text-right">
                    {{ $borrowing->fine > 0 ? 'Rp ' . number_format($borrowing->fine, 0, ',', '.') : '-' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Tidak ada data peminjaman.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Mengetahui,</p>
        <br><br><br>
        <i>Toriq ayataal m</i><br></br>
        <strong>Administrator Perpustakaan</strong>
    </div>

    <script>
        // Auto print dialog when page loads
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
