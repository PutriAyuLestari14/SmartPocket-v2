<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\RekeningTabungan;
use App\Models\DetailTabungan;
use App\Models\Peminjaman;
use App\Models\Angsuran; // <-- Tambahkan ini
use Illuminate\Http\Request;

class TabunganController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $id_nasabah = $user->nasabah->id_nasabah;

        // cari rekening punya user yang login
        $rekening = RekeningTabungan::where('id_nasabah', $id_nasabah)->first();

        // transaksi tabungan yg setuju / berhasil
        $transaksiTabungan = DetailTabungan::whereHas('rekening.nasabah', function ($query) use ($user) {
                $query->where('username', $user->username);
            })
            ->where('status', 'berhasil')
            ->get()
            ->map(function ($trx) {
                return (object) [
                    'tipe' => 'tabungan',
                    'id_jenis_transaksi' => $trx->id_jenis_transaksi,
                    'jumlah' => $trx->jumlah,
                    'status' => $trx->status,
                    'tanggal_transaksi' => $trx->tanggal_transaksi,
                ];
            });

        // peminjaman yg udh di proses
        $transaksiPeminjaman = Peminjaman::where('id_nasabah', $id_nasabah)
            ->whereIn('status_verifikasi', ['disetujui', 'ditolak'])
            ->get()
            ->map(function ($pinjaman) {
                return (object) [
                    'tipe' => 'peminjaman',
                    'jumlah' => $pinjaman->jumlah_pinjaman,
                    'status' => $pinjaman->status_verifikasi,
                    'tanggal_transaksi' => $pinjaman->created_at,
                ];
            });

        // gabungan transaksi yg udh di proses
        $transaksiTerbaru = $transaksiTabungan
            ->concat($transaksiPeminjaman)
            ->sortByDesc('tanggal_transaksi')
            ->take(5)
            ->values();

        // pengajuan penarikan yg masih pending
        $pengajuanPenarikan = null;
        if ($rekening) {
            $pengajuanPenarikan = DetailTabungan::where('no_rek', $rekening->no_rek)
                ->where('id_jenis_transaksi', 2)
                ->where('status', 'pending')
                ->latest('created_at')
                ->first();
        }

        // pengajuan peminjaman yg masih pending
        $pengajuanPeminjaman = Peminjaman::where('id_nasabah', $id_nasabah)
            ->where('status_verifikasi', 'pending')
            ->latest('created_at')
            ->first();

        // pinjaman aktif
        $pinjamanAktif = Peminjaman::where('id_nasabah', $id_nasabah)
            ->where('status_verifikasi', 'disetujui')
            ->where('sisa_pinjaman', '>', 0)
            ->orderBy('tanggal_jatuh_tempo', 'asc')
            ->first();

        // total sisa pinjaman
        $totalSisaPinjaman = Peminjaman::where('id_nasabah', $id_nasabah)
            ->where('status_verifikasi', 'disetujui')
            ->where('sisa_pinjaman', '>', 0)
            ->sum('sisa_pinjaman');

        return view('nasabah.dashboard', compact(
            'rekening',
            'transaksiTerbaru',
            'pengajuanPenarikan',
            'pengajuanPeminjaman',
            'pinjamanAktif',
            'totalSisaPinjaman'
        ));
    }

    public function riwayat(Request $request)
    {
        $user = auth()->user();
        $idNasabah = $user->nasabah->id_nasabah;

        // 1. Setoran dan penarikan yang sudah berhasil/gagal
        $transaksiTabungan = DetailTabungan::whereHas('rekening.nasabah', function ($query) use ($user) {
                $query->where('username', $user->username);
            })
            ->whereIn('status', ['berhasil', 'gagal'])
            ->with(['jenisTransaksi', 'rekening.nasabah'])
            ->get()
            ->map(function ($trx) {
                return (object) [
                    'tipe' => 'tabungan',
                    'sub_tipe' => $trx->id_jenis_transaksi == 1 ? 'Setoran' : 'Penarikan',
                    'tanggal_transaksi' => $trx->tanggal_transaksi,
                    'jumlah' => $trx->jumlah,
                    'status' => $trx->status,
                    'keterangan' => $trx->keterangan ?? '-',
                ];
            });

        // 2. Pinjaman yang sudah diproses (Disetujui/Ditolak)
        $transaksiPeminjaman = Peminjaman::where('id_nasabah', $idNasabah)
            ->whereIn('status_verifikasi', ['disetujui', 'ditolak'])
            ->get()
            ->map(function ($pinjaman) {
                return (object) [
                    'tipe' => 'peminjaman',
                    'sub_tipe' => 'Pengajuan Pinjaman',
                    'tanggal_transaksi' => $pinjaman->created_at,
                    'jumlah' => $pinjaman->jumlah_pinjaman,
                    'status' => $pinjaman->status_verifikasi,
                    'keterangan' => $pinjaman->keterangan ?? '-',
                ];
            });

        // 3. Pembayaran Angsuran (Cicilan) yang sudah dibayar
        $idPinjamanList = Peminjaman::where('id_nasabah', $idNasabah)->pluck('id_pinjaman');
        
        $transaksiAngsuran = Angsuran::whereIn('id_pinjaman', $idPinjamanList)
            ->with('peminjaman') // Pastikan relasi ini ada di model Angsuran
            ->get()
            ->map(function ($angsuran) {
                return (object) [
                    'tipe' => 'angsuran',
                    'sub_tipe' => 'Pembayaran Cicilan',
                    'tanggal_transaksi' => $angsuran->tanggal_pembayaran,
                    'jumlah' => $angsuran->jumlah,
                    'status' => 'berhasil',
                    'keterangan' => 'Cicilan Pinjaman',
                ];
            });

        // Gabungkan semua transaksi dan urutkan dari yang terbaru
        $semuaTransaksi = $transaksiTabungan
            ->concat($transaksiPeminjaman)
            ->concat($transaksiAngsuran)
            ->sortByDesc('tanggal_transaksi')
            ->values();

        // Total setoran
        $totalPemasukan = $transaksiTabungan
            ->filter(function ($trx) {
                return $trx->sub_tipe === 'Setoran' && $trx->status === 'berhasil';
            })
            ->sum('jumlah');

        // Total penarikan
        $totalPengeluaran = $transaksiTabungan
            ->filter(function ($trx) {
                return $trx->sub_tipe === 'Penarikan' && $trx->status === 'berhasil';
            })
            ->sum('jumlah');

        // Pagination manual
        $perPage = 10; // Dinaikkan sedikit agar riwayat angsuran terlihat
        $currentPage = (int) $request->input('page', 1);

        $items = $semuaTransaksi->slice(
            ($currentPage - 1) * $perPage,
            $perPage
        )->values();

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