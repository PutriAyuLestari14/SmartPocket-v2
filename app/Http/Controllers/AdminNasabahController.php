<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\DetailTabungan;
use Carbon\Carbon;

class AdminNasabahController extends Controller
{
    public function index()
    {
        $nasabahs = Nasabah::with(['user', 'rekening'])
            ->join(
                'rekening_tabungan',
                'nasabah.id_nasabah',
                '=',
                'rekening_tabungan.id_nasabah'
            )
            ->orderBy('rekening_tabungan.no_rek', 'asc')
            ->select('nasabah.*')
            ->paginate(10);

        return view('admin.nasabah.index', compact('nasabahs'));
    }

    public function getMutasiNasabah(Request $request, $idNasabah)
    {
        try {
            $nasabah = Nasabah::with('rekening')->findOrFail($idNasabah);

            $periode = $request->periode ?? now()->format('Y-m');

            $awalBulan = Carbon::createFromFormat('Y-m-d', $periode . '-01')->startOfDay();
            $akhirBulan = $awalBulan->copy()->endOfMonth();

            $rekening = $nasabah->rekening;

            if (!$rekening) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nasabah belum memiliki rekening tabungan.'
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | AMBIL SEMUA TRANSAKSI SAMPAI AKHIR BULAN YANG DIPILIH
            |--------------------------------------------------------------------------
            */

            $transaksi = DetailTabungan::where('id_rekening', $rekening->no_rek)
                ->whereDate('tanggal_transaksi', '<=', $akhirBulan)
                ->whereIn('id_jenis_transaksi', [1, 2])
                ->where(function ($query) {
                    $query->whereNull('status')
                        ->orWhere('status', '!=', 'pending');
                })
                ->orderBy('tanggal_transaksi', 'asc')
                ->get();

            /*
            |--------------------------------------------------------------------------
            | HITUNG SALDO AKHIR BULAN
            |
            | Saldo rekening sekarang dikurangi transaksi setelah bulan yang dipilih
            |--------------------------------------------------------------------------
            */

            $saldoAkhirBulan = (float) $rekening->saldo;

            $transaksiSetelahBulan = DetailTabungan::where(
                    'id_rekening',
                    $rekening->no_rek
                )
                ->whereDate('tanggal_transaksi', '>', $akhirBulan)
                ->whereIn('id_jenis_transaksi', [1, 2])
                ->where(function ($query) {
                    $query->whereNull('status')
                        ->orWhere('status', '!=', 'pending');
                })
                ->get();

            foreach ($transaksiSetelahBulan as $trx) {
                if ((int) $trx->id_jenis_transaksi === 1) {
                    // Setoran menambah saldo
                    $saldoAkhirBulan -= (float) $trx->jumlah;
                } elseif ((int) $trx->id_jenis_transaksi === 2) {
                    // Penarikan mengurangi saldo
                    $saldoAkhirBulan += (float) $trx->jumlah;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | HITUNG SALDO AWAL BULAN
            |--------------------------------------------------------------------------
            */

            $saldoAwalBulan = $saldoAkhirBulan;

            foreach ($transaksi as $trx) {
                if ((int) $trx->id_jenis_transaksi === 1) {
                    $saldoAwalBulan -= (float) $trx->jumlah;
                } elseif ((int) $trx->id_jenis_transaksi === 2) {
                    $saldoAwalBulan += (float) $trx->jumlah;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | GENERATE SETIAP TANGGAL
            |--------------------------------------------------------------------------
            */

            $saldoBerjalan = $saldoAwalBulan;
            $saldoHarian = 0;

            $mutasi = [];

            $cursor = $awalBulan->copy();

            while ($cursor->lte($akhirBulan)) {

                $tanggal = $cursor->toDateString();

                $transaksiHariIni = $transaksi->filter(function ($trx) use ($tanggal) {
                    return Carbon::parse($trx->tanggal_transaksi)->toDateString() === $tanggal;
                });

                $totalSetoran = 0;
                $totalPenarikan = 0;

                foreach ($transaksiHariIni as $trx) {

                    if ((int) $trx->id_jenis_transaksi === 1) {
                        $totalSetoran += (float) $trx->jumlah;
                        $saldoBerjalan += (float) $trx->jumlah;
                    }

                    if ((int) $trx->id_jenis_transaksi === 2) {
                        $totalPenarikan += (float) $trx->jumlah;
                        $saldoBerjalan -= (float) $trx->jumlah;
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | SETIAP HARI MASUK KE PERHITUNGAN RATA-RATA
                |--------------------------------------------------------------------------
                */

                $saldoHarian += $saldoBerjalan;

                /*
                |--------------------------------------------------------------------------
                | JENIS TRANSAKSI UNTUK TABEL
                |--------------------------------------------------------------------------
                */

                if ($totalSetoran > 0 && $totalPenarikan > 0) {
                    $jenis = 'setoran & penarikan';
                } elseif ($totalSetoran > 0) {
                    $jenis = 'setoran';
                } elseif ($totalPenarikan > 0) {
                    $jenis = 'penarikan';
                } else {
                    $jenis = 'kosong';
                }

                $mutasi[] = [
                    'no_rek' => $rekening->no_rek,
                    'nama' => $nasabah->nama,
                    'tanggal' => $cursor->format('d/m/Y'),
                    'jenis' => $jenis,
                    'debit' => $totalPenarikan,
                    'kredit' => $totalSetoran,
                    'saldo' => $saldoBerjalan,
                ];

                $cursor->addDay();
            }

            /*
            |--------------------------------------------------------------------------
            | RATA-RATA SALDO
            |--------------------------------------------------------------------------
            */

            $jumlahHari = $awalBulan->daysInMonth;

            $rataRataSaldo = $jumlahHari > 0
                ? $saldoHarian / $jumlahHari
                : 0;

            /*
            |--------------------------------------------------------------------------
            | TOTAL DEBIT / KREDIT
            |--------------------------------------------------------------------------
            */

            $totalDebet = collect($mutasi)->sum('debit');
            $totalKredit = collect($mutasi)->sum('kredit');

            return response()->json([
                'success' => true,

                'periode' => $periode,

                'saldo_awal_bulan' => $saldoAwalBulan,
                'saldo_akhir_bulan' => $saldoAkhirBulan,
                'rata_rata_saldo' => $rataRataSaldo,

                'total_debet' => $totalDebet,
                'total_kredit' => $totalKredit,

                'jumlah_hari' => $jumlahHari,

                'mutasi' => $mutasi,
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}