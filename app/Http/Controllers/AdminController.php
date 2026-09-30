<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\DetailTabungan;
use App\Models\RekeningTabungan;
use App\Models\User;
use App\Models\Peminjaman;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // total nasabah
        $totalNasabah = Nasabah::count();

        // total transaksi tabungan
        $totalTransaksi = DetailTabungan::count();

        // transaksi hari ini
        $transaksiHariIniList = DetailTabungan::whereDate(
            'tanggal_transaksi',
            Carbon::today()
        )->get();

        // total saldo semua rekening
        $totalSaldo = RekeningTabungan::sum('saldo');

        // total operator
        $operatorAktif = User::where('role', 'operator')->count();

        // nasabah baru hari ini
        $nasabahBaruHariIni = Nasabah::whereDate(
            'created_at',
            Carbon::today()
        )->count();

        // sementara
        $pendingVerifikasi = 0;

        // aktivitas terbaru
        $aktivitasNasabah = Nasabah::latest('created_at')
            ->take(3)
            ->get()
            ->map(function ($nasabah) {
                return (object) [
                    'deskripsi' => 'Nasabah baru <strong>' . e($nasabah->nama) . '</strong> terdaftar',
                    'icon' => 'user-plus',
                    'warna' => 'emerald',
                    'created_at' => $nasabah->created_at,
                ];
            });

        $aktivitasTransaksi = DetailTabungan::latest('tanggal_transaksi')
            ->take(3)
            ->get()
            ->map(function ($transaksi) {
                return (object) [
                    'deskripsi' => 'Transaksi tabungan sebesar <strong>Rp ' .
                        number_format($transaksi->jumlah, 0, ',', '.') .
                        '</strong> tercatat',
                    'icon' => 'money-bill-transfer',
                    'warna' => 'blue',
                    'created_at' => $transaksi->tanggal_transaksi,
                ];
            });

        $aktivitasPeminjaman = Peminjaman::latest('tanggal_ajuan')
            ->take(3)
            ->get()
            ->map(function ($pinjaman) {
                return (object) [
                    'deskripsi' => 'Pengajuan peminjaman sebesar <strong>Rp ' .
                        number_format($pinjaman->jumlah_pinjaman, 0, ',', '.') .
                        '</strong> diajukan',
                    'icon' => 'hand-holding-dollar',
                    'warna' => 'amber',
                    'created_at' => $pinjaman->tanggal_ajuan,
                ];
            });

        $aktivitasTerbaru = $aktivitasNasabah
            ->concat($aktivitasTransaksi)
            ->concat($aktivitasPeminjaman)
            ->sortByDesc('created_at')
            ->take(5)
            ->values();

        // grafik 7 hari terakhir
        $grafikHarian = [];

        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::today()->subDays($i);

            $grafikHarian[] = DetailTabungan::whereDate(
                'tanggal_transaksi',
                $tanggal
            )->count();
        }

        // grafik 4 minggu terakhir
        $grafikMingguan = [];

        for ($i = 3; $i >= 0; $i--) {
            $mulai = Carbon::today()
                ->startOfWeek()
                ->subWeeks($i);

            $selesai = $mulai->copy()->endOfWeek();

            $grafikMingguan[] = DetailTabungan::whereBetween(
                'tanggal_transaksi',
                [$mulai, $selesai]
            )->count();
        }

        // grafik bulanan
        $grafikBulanan = [];

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $grafikBulanan[] = DetailTabungan::whereYear(
                'tanggal_transaksi',
                Carbon::today()->year
            )
            ->whereMonth('tanggal_transaksi', $bulan)
            ->count();
        }

        return view('admin.dashboard', compact(
            'totalNasabah',
            'totalTransaksi',
            'transaksiHariIniList',
            'totalSaldo',
            'operatorAktif',
            'pendingVerifikasi',
            'nasabahBaruHariIni',
            'aktivitasTerbaru',
            'grafikHarian',
            'grafikMingguan',
            'grafikBulanan'
        ));
    }
}