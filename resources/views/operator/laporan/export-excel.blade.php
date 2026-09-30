<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta charset="UTF-8">
    <title>Jurnal Umum</title>
    <style>
        table { border-collapse: collapse; width: 100%; font-family: Arial, sans-serif; }
        th, td { border: 1px solid #000000; padding: 6px 10px; text-align: left; }
        th { background-color: #15803d; color: #ffffff; font-weight: bold; text-align: center; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .italic { font-style: italic; }
        .indent { padding-left: 30px; }
        .bg-gray { background-color: #f1f5f9; }
        .header-title { font-size: 16px; font-weight: bold; text-align: center; margin-bottom: 10px; }
    </style>
</head>
<body>

    <div class="header-title">
        JURNAL UMUM - BMT SMKN 11 BANDUNG<br>
        <span style="font-size: 12px; font-weight: normal;">Periode: {{ request('tanggal_mulai') ? \Carbon\Carbon::parse(request('tanggal_mulai'))->format('d/m/Y') : 'Awal' }} - {{ request('tanggal_akhir') ? \Carbon\Carbon::parse(request('tanggal_akhir'))->format('d/m/Y') : 'Akhir' }}</span>
    </div>

    <table>
        <thead>
            <tr>
                <th width="12%">Tanggal</th>
                <th width="35%">Nama Akun (CoA) & Keterangan</th>
                <th width="15%">No. Bukti</th>
                <th width="18%" class="text-right">Debit (Rp)</th>
                <th width="18%" class="text-right">Kredit (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($jurnalData as $noBukti => $entries)
                @php
                    $firstEntry = $entries->first();
                    $totalDebitTransaksi = $entries->sum('debit');
                    $totalKreditTransaksi = $entries->sum('kredit');
                @endphp

                @foreach ($entries as $index => $entry)
                    <tr>
                        <td class="text-center">
                            @if($index === 0)
                                {{ \Carbon\Carbon::parse($firstEntry['tanggal'])->format('d/m/Y') }}
                            @endif
                        </td>
                        <td>
                            @if($entry['kredit'] > 0)
                                <div class="indent italic">{{ $entry['akun'] }}</div>
                            @else
                                <div class="font-bold">{{ $entry['akun'] }}</div>
                            @endif
                            
                            @if($index === 0 && isset($firstEntry['keterangan']) && $firstEntry['keterangan'])
                                <div style="font-size: 10px; color: #666; margin-top: 2px;">
                                    <i>{{ $firstEntry['keterangan'] }}</i>
                                </div>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($index === 0)
                                {{ $noBukti }}
                            @endif
                        </td>
                        <td class="text-right">
                            @if($entry['debit'] > 0)
                                {{ number_format($entry['debit'], 0, ',', '.') }}
                            @endif
                        </td>
                        <td class="text-right">
                            @if($entry['kredit'] > 0)
                                {{ number_format($entry['kredit'], 0, ',', '.') }}
                            @endif
                        </td>
                    </tr>
                @endforeach

                <!-- Baris Subtotal -->
                <tr class="bg-gray">
                    <td colspan="3" class="text-right font-bold" style="border-right: none;">Subtotal Transaksi:</td>
                    <td class="text-right font-bold" style="border-left: none;">{{ number_format($totalDebitTransaksi, 0, ',', '.') }}</td>
                    <td class="text-right font-bold">{{ number_format($totalKreditTransaksi, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data jurnal untuk periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr style="background-color: #15803d; color: white; font-weight: bold;">
                <td colspan="3" class="text-right">TOTAL KESELURUHAN</td>
                <td class="text-right">{{ number_format($totalDebit, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($totalKredit, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

</body>
</html>