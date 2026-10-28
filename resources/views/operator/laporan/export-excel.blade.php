<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Jurnal Umum</title>

    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        th, td {
            border: 1px solid #000;
            padding: 7px 10px;
        }

        th {
            background-color: #15803d;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        .text-right {
            text-align: right;
            white-space: nowrap;
        }

        .text-center {
            text-align: center;
        }

        .font-bold {
            font-weight: bold;
        }

        .italic {
            font-style: italic;
        }

        .indent {
            padding-left: 30px;
        }

        .header-title {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="header-title">
        JURNAL UMUM - BMT SMKN 11 BANDUNG
        <br>
        <span style="font-size: 12px; font-weight: normal;">
            Periode:
            {{ request('tanggal_mulai') ? \Carbon\Carbon::parse(request('tanggal_mulai'))->format('d/m/Y') : 'Awal' }}
            -
            {{ request('tanggal_akhir') ? \Carbon\Carbon::parse(request('tanggal_akhir'))->format('d/m/Y') : 'Akhir' }}
        </span>
    </div>

    <table>
        <thead>
            <tr>
                <th width="15%">Tanggal</th>
                <th width="20%">No. Rekening</th>
                <th width="35%">Nama Akun (CoA) &amp; Keterangan</th>
                <th width="15%">Debit (Rp)</th>
                <th width="15%">Kredit (Rp)</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($jurnalData as $noBukti => $entries)
                @foreach ($entries as $index => $entry)
                    <tr>
                        <td class="text-center">
                            @if ($index === 0)
                                {{ \Carbon\Carbon::parse($entry['tanggal'])->format('d/m/Y') }}
                            @endif
                        </td>

                        <td class="text-center">
                            @if ($loop->first)
                                {{ $entry['no_rekening'] ?? '-' }}
                            @endif
                        </td>

                        <td>
                            @if (($entry['kredit'] ?? 0) > 0)
                                <div class="indent italic">
                                    {{ $entry['akun'] }}
                                </div>
                            @else
                                <div class="font-bold">
                                    {{ $entry['akun'] }}
                                </div>
                            @endif

                            @if ($index === 0 && !empty($entry['keterangan']))
                                <div style="font-size: 10px; color: #666; margin-top: 3px;">
                                    <i>{{ $entry['keterangan'] }}</i>
                                </div>
                            @endif
                        </td>

                        <td class="text-right">
                            @if (($entry['debit'] ?? 0) > 0)
                                {{ number_format((float) $entry['debit'], 0, ',', '.') }}
                            @endif
                        </td>

                        <td class="text-right">
                            @if (($entry['kredit'] ?? 0) > 0)
                                {{ number_format((float) $entry['kredit'], 0, ',', '.') }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="5" class="text-center">
                        Tidak ada data jurnal untuk periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>

        <tfoot>
            <tr style="background-color: #15803d; color: white; font-weight: bold;">
                <td colspan="3" class="text-right">
                    TOTAL KESELURUHAN
                </td>
                <td class="text-right">
                    {{ number_format((float) $totalDebit, 0, ',', '.') }}
                </td>
                <td class="text-right">
                    {{ number_format((float) $totalKredit, 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
