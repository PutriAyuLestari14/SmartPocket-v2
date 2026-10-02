<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\Angsuran;
use App\Models\DetailTabungan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminSaldoController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->periode ?? now()->format('Y-m');

        $tahun = Carbon::parse($periode . '-01')->year;
        $bulan = Carbon::parse($periode . '-01')->month;

        $totalJasa = Angsuran::whereYear('tanggal_pembayaran', $tahun)
            ->whereMonth('tanggal_pembayaran', $bulan)
            ->sum('jumlah_jasa');

        $nasabahs = Nasabah::with('rekening')
            ->orderBy('nama', 'asc')
            ->paginate(10)
            ->withQueryString();

        $totalBagiHasil = 0;
        $sudahDiproses = false;

        return view('admin.saldo.index', compact(
            'nasabahs',
            'periode',
            'totalJasa',
            'totalBagiHasil',
            'sudahDiproses'
        ));
    }

    public function mutasiNasabah(Request $request, $idNasabah)
    {
        $periode = $request->periode ?? now()->format('Y-m');

        $tanggalMulai = Carbon::createFromFormat(
            'Y-m-d',
            $periode . '-01'
        )->startOfDay();

        $tanggalSelesai = $tanggalMulai->copy()->endOfMonth()->endOfDay();

        // Ambil data nasabah
        $nasabah = Nasabah::with('rekening')
            ->where('id_nasabah', $idNasabah)
            ->firstOrFail();

        $rekening = $nasabah->rekening;

        if (!$rekening) {
            return response()->json([
                'success' => false,
                'message' => 'Rekening nasabah tidak ditemukan.'
            ]);
        }

        $noRek = $rekening->no_rek;

        /*
        |--------------------------------------------------------------------------
        | AMBIL SEMUA TRANSAKSI
        |--------------------------------------------------------------------------
        */

        $transaksi = DetailTabungan::where('no_rek', $noRek)
            ->where('status', '!=', 'pending')
            ->whereDate('tanggal_transaksi', '<=', $tanggalSelesai)
            ->orderBy('tanggal_transaksi', 'asc')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | HITUNG SALDO AKHIR BULAN
        |--------------------------------------------------------------------------
        |
        | Saldo rekening sekarang kita jadikan titik referensi.
        | Transaksi setelah periode yang dipilih dibalik agar mendapatkan
        | saldo akhir pada bulan yang dipilih.
        |
        */

        $saldoSekarang = (float) $rekening->saldo;

        $transaksiSetelahBulan = DetailTabungan::where('no_rek', $noRek)
            ->where('status', '!=', 'pending')
            ->whereDate('tanggal_transaksi', '>', $tanggalSelesai)
            ->get();

        $pengaruhSetelahBulan = 0;

        foreach ($transaksiSetelahBulan as $item) {
            if ($item->id_jenis_transaksi == 1) {
                // Setoran menambah saldo
                $pengaruhSetelahBulan += (float) $item->jumlah;
            } elseif ($item->id_jenis_transaksi == 2) {
                // Penarikan mengurangi saldo
                $pengaruhSetelahBulan -= (float) $item->jumlah;
            }
        }

        $saldoAkhirBulan = $saldoSekarang - $pengaruhSetelahBulan;

        /*
        |--------------------------------------------------------------------------
        | HITUNG SALDO AWAL BULAN
        |--------------------------------------------------------------------------
        */

        $transaksiDalamBulan = $transaksi->filter(function ($item) use (
            $tanggalMulai,
            $tanggalSelesai
        ) {
            $tanggal = Carbon::parse($item->tanggal_transaksi);

            return $tanggal->between(
                $tanggalMulai,
                $tanggalSelesai
            );
        });

        $pengaruhDalamBulan = 0;

        foreach ($transaksiDalamBulan as $item) {
            if ($item->id_jenis_transaksi == 1) {
                $pengaruhDalamBulan += (float) $item->jumlah;
            } elseif ($item->id_jenis_transaksi == 2) {
                $pengaruhDalamBulan -= (float) $item->jumlah;
            }
        }

        $saldoAwalBulan = $saldoAkhirBulan - $pengaruhDalamBulan;

        /*
        |--------------------------------------------------------------------------
        | BUAT MUTASI SETIAP HARI
        |--------------------------------------------------------------------------
        |
        | Walaupun tidak ada transaksi, tanggal tetap dimunculkan.
        |
        */

        $mutasi = [];

        $saldoBerjalan = $saldoAwalBulan;
        $totalSaldoHarian = 0;
        $totalDebet = 0;
        $totalKredit = 0;

        $jumlahHari = $tanggalMulai->daysInMonth;

        for ($i = 0; $i < $jumlahHari; $i++) {

            $tanggal = $tanggalMulai->copy()->addDays($i);

            $transaksiHariIni = $transaksi->filter(function ($item) use ($tanggal) {
                return Carbon::parse($item->tanggal_transaksi)
                    ->isSameDay($tanggal);
            });

            $debetHariIni = 0;
            $kreditHariIni = 0;

            foreach ($transaksiHariIni as $item) {

                $jumlah = (float) $item->jumlah;

                if ($item->id_jenis_transaksi == 1) {
                    // SETORAN = KREDIT
                    $kreditHariIni += $jumlah;
                }

                if ($item->id_jenis_transaksi == 2) {
                    // PENARIKAN = DEBET
                    $debetHariIni += $jumlah;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | UPDATE SALDO HARIAN
            |--------------------------------------------------------------------------
            */

            $saldoBerjalan =
                $saldoBerjalan
                + $kreditHariIni
                - $debetHariIni;

            $totalDebet += $debetHariIni;
            $totalKredit += $kreditHariIni;

            $totalSaldoHarian += $saldoBerjalan;

            /*
            |--------------------------------------------------------------------------
            | TENTUKAN JENIS
            |--------------------------------------------------------------------------
            */

            if ($kreditHariIni > 0 && $debetHariIni > 0) {
                $jenis = 'setoran & penarikan';
            } elseif ($kreditHariIni > 0) {
                $jenis = 'setoran';
            } elseif ($debetHariIni > 0) {
                $jenis = 'penarikan';
            } else {
                $jenis = '-';
            }

            /*
            |--------------------------------------------------------------------------
            | MASUKKAN KE DATA MUTASI
            |--------------------------------------------------------------------------
            */

            $mutasi[] = [
                'no_rek' => $noRek,
                'nama' => $nasabah->nama,
                'tanggal' => $tanggal->format('Y-m-d'),
                'jenis' => $jenis,
                'debit' => $debetHariIni,
                'kredit' => $kreditHariIni,
                'saldo' => $saldoBerjalan,
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | RATA-RATA SALDO
        |--------------------------------------------------------------------------
        */

        $rataRataSaldo = $jumlahHari > 0
            ? $totalSaldoHarian / $jumlahHari
            : 0;

        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'success' => true,

            'saldo_awal_bulan' => round($saldoAwalBulan, 2),

            'saldo_akhir_bulan' => round($saldoAkhirBulan, 2),

            'rata_rata_saldo' => round($rataRataSaldo, 2),

            'total_debet' => round($totalDebet, 2),

            'total_kredit' => round($totalKredit, 2),

            'mutasi' => $mutasi,
        ]);
    }
}