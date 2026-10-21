<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta charset="UTF-8">
    <title>Neraca BMT</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; }
        th, td { border: 1px solid #000000; padding: 6px 10px; }
        th { background-color: #1A4D2E; color: #ffffff; font-weight: bold; text-align: center; font-size: 11px; }
        .header-title { font-size: 16px; font-weight: bold; text-align: center; margin-bottom: 3px; }
        .header-sub { font-size: 12px; text-align: center; margin-bottom: 15px; color: #333; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .bg-total { background-color: #1A4D2E; color: white; font-weight: bold; }
        .kode-akun { font-family: 'Courier New', monospace; font-weight: bold; }
    </style>
</head>
<body>

    <div class="header-title">BMT SMKN 11 BANDUNG</div>
    <div class="header-title">LAPORAN NERACA SALDO</div>
    <div class="header-sub">Periode: {{ \Carbon\Carbon::parse($tanggalMulai)->isoFormat('D MMMM YYYY') }} s.d. {{ \Carbon\Carbon::parse($tanggalSelesai)->isoFormat('D MMMM YYYY') }}</div>

    <table>
        <thead>
            <tr>
                <th rowspan="2" width="12%">Kode Akun</th>
                <th rowspan="2" width="22%">Nama Akun</th>
                <th colspan="2">Saldo Awal</th>
                <th colspan="2">Mutasi Periode</th>
                <th colspan="2">Saldo Akhir</th>
            </tr>
            <tr>
                <th width="11%">Debit</th>
                <th width="11%">Kredit</th>
                <th width="11%">Debit</th>
                <th width="11%">Kredit</th>
                <th width="11%">Debit</th>
                <th width="11%">Kredit</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($akun as $item)
                <tr>
                    <td class="text-center kode-akun">{{ $item['kode'] }}</td>
                    <td class="font-bold">{{ $item['nama'] }}</td>
                    <td class="text-right">{{ number_format($item['awal_debit'], 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item['awal_kredit'], 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item['mutasi_debit'], 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item['mutasi_kredit'], 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item['akhir_debit'], 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item['akhir_kredit'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="bg-total">
                <td colspan="2" class="text-center">TOTAL</td>
                <td class="text-right">{{ number_format($totalAwalDebit, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($totalAwalKredit, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($totalMutasiDebit, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($totalMutasiKredit, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($totalAkhirDebit, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($totalAkhirKredit, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 40px; text-align: right; font-size: 12px; padding-right: 50px;">
        <p>Bandung, {{ \Carbon\Carbon::parse($tanggalSelesai)->isoFormat('D MMMM YYYY') }}</p>
        <p style="margin-top: 60px; font-weight: bold; text-decoration: underline;">( Administrator BMT )</p>
    </div>

</body>
</html>