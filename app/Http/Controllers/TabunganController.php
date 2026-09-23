<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\RekeningTabungan;
use App\Models\DetailTabungan;
use App\Models\Peminjaman;
use App\Models\Angsuran;
use Illuminate\Http\Request;

class TabunganController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $id_nasabah = $user->nasabah->id_nasabah;

        // Cari rekening milik user yang login
        $rekening = RekeningTabungan::where('id_nasabah', $id_nasabah)->first();

        // 1. Transaksi tabungan yang sudah diproses
        $transaksiTabungan = DetailTabungan::whereHas(
            'rekening.nasabah',
            function ($query) use ($user) {
                $query->where('username', $user->username);
            }
        )
        ->whereIn('status', ['berhasil', 'gagal'])
        ->get()
        ->map(function ($trx) {
            return (object) [
                'tipe' => 'tabungan',
                'sub_tipe' => $trx->id_jenis_transaksi == 1 ? 'Setoran' : 'Penarikan',
                'id_jenis_transaksi' => $trx->id_jenis_transaksi,
                'tanggal_transaksi' => $trx->tanggal_transaksi,
                'jumlah' => $trx->jumlah,
                'status' => $trx->status,
                'keterangan' => $trx->keterangan ?? '-',
                'jenisTransaksi' => $trx->jenisTransaksi,
            ];
        });

        // 2. Peminjaman yang sudah diproses
        $transaksiPeminjaman = Peminjaman::where('id_nasabah', $id_nasabah)
        ->whereIn('status_verifikasi', ['disetujui', 'ditolak'])
        ->get()
        ->map(function ($pinjaman) {
            return (object) [
                'tipe' => 'peminjaman',
                'sub_tipe' => 'Pengajuan Pinjaman',
                'id_jenis_transaksi' => null,
                'tanggal_transaksi' => $pinjaman->created_at,
                'jumlah' => $pinjaman->jumlah_pinjaman,
                'status' => $pinjaman->status_verifikasi,
                'keterangan' => $pinjaman->keterangan ?? '-',
                'jenisTransaksi' => null,
            ];
        });

        // 3. Pembayaran angsuran yang sudah dilakukan
        $idPinjamanList = Peminjaman::where('id_nasabah', $id_nasabah)->pluck('id_pinjaman');

        $transaksiAngsuran = Angsuran::whereIn('id_pinjaman', $idPinjamanList)
        ->get()
        ->map(function ($angsuran) {
            return (object) [
                'tipe' => 'angsuran',
                'sub_tipe' => 'Pembayaran Cicilan',
                'id_jenis_transaksi' => null,
                'tanggal_transaksi' => $angsuran->created_at,
                'jumlah' => $angsuran->jumlah,
                'status' => 'berhasil',
                'keterangan' => 'Cicilan Pinjaman',
                'jenisTransaksi' => null,
            ];
        });

        // 4. Gabungkan semua transaksi
        $transaksiTerbaru = $transaksiTabungan
            ->concat($transaksiPeminjaman)
            ->concat($transaksiAngsuran)
            ->sortByDesc(function ($trx) {
                return $trx->tanggal_transaksi;
            })
            ->take(5)
            ->values();

        // Pengajuan penarikan yang masih pending
        $pengajuanPenarikan = null;
        if ($rekening) {
            $pengajuanPenarikan = DetailTabungan::where('no_rek', $rekening->no_rek)
                ->where('id_jenis_transaksi', 2)
                ->where('status', 'pending')
                ->latest('created_at')
                ->first();
        }

        // Pengajuan peminjaman yang masih pending
        $pengajuanPeminjaman = Peminjaman::where('id_nasabah', $id_nasabah)
            ->where('status_verifikasi', 'pending')
            ->latest('created_at')
            ->first();

        // Pinjaman aktif
        $pinjamanAktif = Peminjaman::where('id_nasabah', $id_nasabah)
            ->where('status_verifikasi', 'disetujui')
            ->where('sisa_pinjaman', '>', 0)
            ->orderBy('tanggal_jatuh_tempo', 'asc')
            ->first();

        // ==========================================
        // PERBAIKAN: Hitung Sisa Pokok setelah dikurangi Provisi 1%
        // ==========================================
        $totalSisaPokokRaw = Peminjaman::where('id_nasabah', $id_nasabah)
            ->where('status_verifikasi', 'disetujui')
            ->where('sisa_pinjaman', '>', 0)
            ->get();

        // Kurangi provisi 1% dari setiap pinjaman
        $totalSisaPokok = $totalSisaPokokRaw->sum(function($p) {
            $provisi = $p->jumlah_pinjaman * 0.01;
            return max(0, $p->sisa_pinjaman - $provisi);
        });

        $totalSisaBunga = $totalSisaPokokRaw->sum('sisa_bunga') ?? 0;
        $totalKewajiban = $totalSisaPokok + $totalSisaBunga;

        return view('nasabah.dashboard', compact(
            'rekening',
            'transaksiTerbaru',
            'pengajuanPenarikan',
            'pengajuanPeminjaman',
            'pinjamanAktif',
            'totalSisaPokok',
            'totalSisaBunga',
            'totalKewajiban'
        ));
    }

    public function riwayat(Request $request)
    {
        $user = auth()->user();
        $idNasabah = $user->nasabah->id_nasabah;

        // 1. Setoran dan penarikan yang sudah diproses
        $transaksiTabungan = DetailTabungan::whereHas(
            'rekening.nasabah',
            function ($query) use ($user) {
                $query->where('username', $user->username);
            }
        )
        ->whereIn('status', ['berhasil', 'gagal'])
        ->with(['jenisTransaksi', 'rekening.nasabah'])
        ->get()
        ->map(function ($trx) {
            return (object) [
                'tipe' => 'tabungan',
                'sub_tipe' => $trx->id_jenis_transaksi == 1 ? 'Setoran' : 'Penarikan',
                'id_jenis_transaksi' => $trx->id_jenis_transaksi,
                'tanggal_transaksi' => $trx->tanggal_transaksi,
                'jumlah' => $trx->jumlah,
                'status' => $trx->status,
                'keterangan' => $trx->keterangan ?? '-',
                'jenisTransaksi' => $trx->jenisTransaksi,
            ];
        });

        // 2. Pinjaman yang sudah diproses
        $transaksiPeminjaman = Peminjaman::where('id_nasabah', $idNasabah)
        ->whereIn('status_verifikasi', ['disetujui', 'ditolak'])
        ->get()
        ->map(function ($pinjaman) {
            return (object) [
                'tipe' => 'peminjaman',
                'sub_tipe' => 'Pengajuan Pinjaman',
                'id_jenis_transaksi' => null,
                'tanggal_transaksi' => $pinjaman->created_at,
                'jumlah' => $pinjaman->jumlah_pinjaman,
                'status' => $pinjaman->status_verifikasi,
                'keterangan' => $pinjaman->keterangan ?? '-',
                'jenisTransaksi' => null,
            ];
        });

        // 3. Pembayaran angsuran yang sudah dilakukan
        $idPinjamanList = Peminjaman::where('id_nasabah', $idNasabah)->pluck('id_pinjaman');

        $transaksiAngsuran = Angsuran::whereIn('id_pinjaman', $idPinjamanList)
        ->get()
        ->map(function ($angsuran) {
            return (object) [
                'tipe' => 'angsuran',
                'sub_tipe' => 'Pembayaran Cicilan',
                'id_jenis_transaksi' => null,
                'tanggal_transaksi' => $angsuran->created_at,
                'jumlah' => $angsuran->jumlah,
                'status' => 'berhasil',
                'keterangan' => 'Cicilan Pinjaman',
                'jenisTransaksi' => null,
            ];
        });

        // 4. Gabungkan semua transaksi
        $semuaTransaksi = $transaksiTabungan
            ->concat($transaksiPeminjaman)
            ->concat($transaksiAngsuran)
            ->sortByDesc(function ($trx) {
                return $trx->tanggal_transaksi;
            })
            ->values();

        // Total pemasukan
        $totalPemasukan = $transaksiTabungan
            ->filter(function ($trx) {
                return $trx->sub_tipe === 'Setoran' && $trx->status === 'berhasil';
            })
            ->sum('jumlah');

        // Total pengeluaran
        $totalPengeluaran = $transaksiTabungan
            ->filter(function ($trx) {
                return $trx->sub_tipe === 'Penarikan' && $trx->status === 'berhasil';
            })
            ->sum('jumlah');

        // Pagination manual
        $perPage = 10;
        $currentPage = (int) $request->input('page', 1);

        $items = $semuaTransaksi
            ->slice(($currentPage - 1) * $perPage, $perPage)
            ->values();

        $transaksi = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $semuaTransaksi->count(),
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('nasabah.riwayat', compact(
            'transaksi',
            'totalPemasukan',
            'totalPengeluaran'
        ));
    }
}