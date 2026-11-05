<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\RekeningTabungan;
use App\Models\DetailTabungan;

class OperatorController extends Controller
{
    public function index()
    {
        // Hitung total semua nasabah yang terdaftar di sistem
        $totalNasabah = Nasabah::count();

        // Hitung total saldo tabungan
        $totalSaldoTabungan = RekeningTabungan::sum('saldo');

        // Hitung jumlah buku tabungan yang berhasil dibayarkan
        $jumlahBuku = DetailTabungan::where('status', 'berhasil')
            ->whereHas('jenisTransaksi', function ($q) {
                $q->whereRaw('LOWER(TRIM(setoran)) = ?', ['setoran']);
            })
            ->whereRaw('LOWER(keterangan) LIKE ?', ['%buku tabungan%'])
            ->count();

        $pendapatanBuku = $jumlahBuku * 5000;

        // Hitung saldo kas BMT
        $totalSaldo = $totalSaldoTabungan;

        // Hitung transaksi hari ini
        $transaksiHariIni = DetailTabungan::whereDate(
            'tanggal_transaksi',
            today()
        )->count();

        // Hitung transaksi minggu ini
        $transaksiMingguIni = DetailTabungan::whereBetween(
            'tanggal_transaksi',
            [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ]
        )->count();

        // Hitung penarikan yang masih menunggu verifikasi
        $penarikanPending = DetailTabungan::where('status', 'pending')
            ->whereHas('jenisTransaksi', function ($q) {
                $q->whereRaw(
                    'LOWER(TRIM(penarikan)) = ?',
                    ['penarikan']
                );
            })
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Transaksi terbaru untuk dashboard
        |--------------------------------------------------------------------------
        */

        // Ambil transaksi yang bukan pending beserta relasinya
        $detailTabungan = DetailTabungan::with([
            'jenisTransaksi',
            'rekening.nasabah',
        ])
            ->where('status', '!=', 'pending')
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        // Kenali transaksi biaya buku tabungan
        $adalahBiayaBuku = function ($item) {
            $keterangan = strtolower(trim($item->keterangan ?? ''));

            return str_contains($keterangan, 'biaya buku tabungan')
                || str_contains($keterangan, 'pembayaran buku tabungan');
        };

        // Transaksi tabungan biasa tidak memasukkan biaya buku
        $transaksiTabungan = $detailTabungan->filter(
            function ($item) use ($adalahBiayaBuku) {
                return !$adalahBiayaBuku($item);
            }
        );

        // Biaya buku yang berhasil ditampilkan sebagai Pendapatan Lain-lain
        $transaksiPendapatan = $detailTabungan
            ->filter(function ($item) use ($adalahBiayaBuku) {
                return $item->status === 'berhasil'
                    && $adalahBiayaBuku($item);
            })
            ->map(function ($item) {
                return (object) [
                    'id' => 'buku-' . $item->id,
                    'id_jenis_transaksi' => null,
                    'jumlah' => 5000,
                    'tanggal_transaksi' => $item->tanggal_transaksi,
                    'status' => 'berhasil',
                    'keterangan' => 'Biaya Buku Tabungan',
                    'rekening' => $item->rekening,
                    'jenisTransaksi' => null,
                    'is_pendapatan_lain_lain' => true,
                ];
            });

        // Gabungkan transaksi biasa dan Pendapatan Lain-lain
        $transaksiTerkini = $transaksiTabungan
            ->concat($transaksiPendapatan)
            ->sortByDesc(function ($item) {
                return $item->tanggal_transaksi;
            })
            ->take(8)
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Statistik setoran dan penarikan bulan ini
        |--------------------------------------------------------------------------
        */

        // Hitung total setoran bulan ini
        $totalSetoranBulanIni = DetailTabungan::whereMonth(
            'tanggal_transaksi',
            now()->month
        )
            ->whereYear(
                'tanggal_transaksi',
                now()->year
            )
            ->whereHas('jenisTransaksi', function ($q) {
                $q->whereRaw(
                    'LOWER(TRIM(setoran)) = ?',
                    ['setoran']
                );
            })
            ->sum('jumlah');

        // Hitung total penarikan bulan ini
        $totalPenarikanBulanIni = DetailTabungan::whereMonth(
            'tanggal_transaksi',
            now()->month
        )
            ->whereYear(
                'tanggal_transaksi',
                now()->year
            )
            ->whereHas('jenisTransaksi', function ($q) {
                $q->whereRaw(
                    'LOWER(TRIM(penarikan)) = ?',
                    ['penarikan']
                );
            })
            ->sum('jumlah');

        // Kirim data ke halaman Dashboard Operator
        return view('operator.dashboard', [
            'totalNasabah' => $totalNasabah,
            'totalSaldo' => $totalSaldo,
            'transaksiHariIni' => $transaksiHariIni,
            'transaksiMingguIni' => $transaksiMingguIni,
            'penarikanPending' => $penarikanPending,
            'transaksiTerkini' => $transaksiTerkini,
            'totalSetoranBulanIni' => $totalSetoranBulanIni,
            'totalPenarikanBulanIni' => $totalPenarikanBulanIni,
        ]);
    }
}
