<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\RekeningTabungan;
use App\Models\DetailTabungan;

class OperatorController extends Controller
{
    public function index()
    {
        // hitung total semua nasabah yang terdaftar di sistem
        $totalNasabah = Nasabah::count();

        // hitung total saldo tabungan
        $totalSaldoTabungan = RekeningTabungan::sum('saldo');

        // hitung pendapatan buku tabungan
        $jumlahBuku = DetailTabungan::where('status', 'berhasil')
            ->whereHas('jenisTransaksi', function ($q) {
                $q->whereRaw('LOWER(TRIM(setoran)) = ?', ['setoran']);
            })
            ->whereRaw('LOWER(keterangan) LIKE ?', ['%buku tabungan%'])
            ->count();

        $pendapatanBuku = $jumlahBuku * 5000;

        // hitung saldo kas bmt
        $totalSaldo = $totalSaldoTabungan + $pendapatanBuku;

        // hitung berapa banyak transaksi yang terjadi tepat hari ini
        $transaksiHariIni = DetailTabungan::whereDate(
            'tanggal_transaksi',
            today()
        )->count();

        // hitung total transaksi dari awal minggu sampai akhir minggu ini
        $transaksiMingguIni = DetailTabungan::whereBetween(
            'tanggal_transaksi',
            [
                now()->startOfWeek(),
                now()->endOfWeek()
            ]
        )->count();

        // hitung khusus penarikan yang masih nunggu verifikasi (status pending)
        $penarikanPending = DetailTabungan::where('status', 'pending')
            ->whereHas('jenisTransaksi', function ($q) {
                // cek kolom penarikan di tabel jenis transaksi
                $q->whereRaw('LOWER(TRIM(penarikan)) = ?', ['penarikan']);
            })
            ->count();

        // sertakan data jenis transaksi dan nama nasabahnya biar bisa ditampilkan
        $transaksiTerkini = DetailTabungan::with([
            'jenisTransaksi',
            'rekening.nasabah'
        ])
            ->where('status', '!=', 'pending')
            ->orderBy('tanggal_transaksi', 'desc')
            ->take(8)
            ->get();

        // hitung total uang masuk (setoran) di bulan dan tahun ini
        $totalSetoranBulanIni = DetailTabungan::whereMonth(
            'tanggal_transaksi',
            now()->month
        )
        ->whereYear(
            'tanggal_transaksi',
            now()->year
        )
        ->whereHas('jenisTransaksi', function ($q) {
            $q->whereRaw('LOWER(TRIM(setoran)) = ?', ['setoran']);
        })
        ->sum('jumlah');

        // hitung total uang keluar (penarikan) di bulan dan tahun ini
        $totalPenarikanBulanIni = DetailTabungan::whereMonth(
            'tanggal_transaksi',
            now()->month
        )
        ->whereYear(
            'tanggal_transaksi',
            now()->year
        )
        ->whereHas('jenisTransaksi', function ($q) {
            $q->whereRaw('LOWER(TRIM(penarikan)) = ?', ['penarikan']);
        })
        ->sum('jumlah');

        // kirim semua data statistik ini ke halaman view dashboard operator
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