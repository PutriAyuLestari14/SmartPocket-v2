<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\RekeningTabungan;
use App\Models\DetailTabungan;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class TabunganController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $id_nasabah = $user->nasabah->id_nasabah;

        // cari rekening punya user yang login
        $rekening = RekeningTabungan::where(
            'id_nasabah',
            $id_nasabah
        )->first();

        // transaksi tabungan yg setuju / berhasil
        $transaksiTabungan = DetailTabungan::whereHas(
            'rekening.nasabah',
            function ($query) use ($user) {
                $query->where('username', $user->username);
            }
        )
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
        $transaksiPeminjaman = Peminjaman::where(
            'id_nasabah',
            $id_nasabah
        )
        ->whereIn('status_verifikasi', [
            'disetujui',
            'ditolak'
        ])
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
            $pengajuanPenarikan = DetailTabungan::where(
                'no_rek',
                $rekening->no_rek
            )
            ->where('id_jenis_transaksi', 2)
            ->where('status', 'pending')
            ->latest('created_at')
            ->first();
        }

        // pengajuan peminjaman yg masih pending
        $pengajuanPeminjaman = Peminjaman::where(
            'id_nasabah',
            $id_nasabah
        )
        ->where('status_verifikasi', 'pending')
        ->latest('created_at')
        ->first();

        // pinjaman aktif
        $pinjamanAktif = Peminjaman::where(
            'id_nasabah',
            $id_nasabah
        )
        ->where('status_verifikasi', 'disetujui')
        ->where('sisa_pinjaman', '>', 0)
        ->orderBy('tanggal_jatuh_tempo', 'asc')
        ->first();

        // totall sisa pinjaman
        $totalSisaPinjaman = Peminjaman::where(
            'id_nasabah',
            $id_nasabah
        )
        ->where('status_verifikasi', 'disetujui')
        ->where('sisa_pinjaman', '>', 0)
        ->sum('sisa_pinjaman');

        // kirim data ke dashboard
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

        // setoran dan penarikan yg udh berhaisl
       $transaksiTabungan = DetailTabungan::whereHas(
            'rekening.nasabah',
            function ($query) use ($user) {
                $query->where('username', $user->username);
            }
        )
        ->whereIn('status', ['berhasil', 'gagal'])
        ->with([
            'jenisTransaksi',
            'rekening.nasabah'
        ])
        ->get()
        ->map(function ($trx) {
            return (object) [
                'tipe' => 'tabungan',
                'tanggal_transaksi' => $trx->tanggal_transaksi,
                'jumlah' => $trx->jumlah,
                'status' => $trx->status,
                'jenisTransaksi' => $trx->jenisTransaksi,
                'keterangan' => $trx->keterangan,
            ];
        });

        // pinjaman yg udh di proses
        $transaksiPeminjaman = Peminjaman::where(
            'id_nasabah',
            $idNasabah
        )
        ->whereIn('status_verifikasi', [
            'disetujui',
            'ditolak'
        ])
        ->get()
        ->map(function ($pinjaman) {
            return (object) [
                'tipe' => 'peminjaman',
                'tanggal_transaksi' => $pinjaman->created_at,
                'jumlah' => $pinjaman->jumlah_pinjaman,
                'status' => $pinjaman->status_verifikasi,
                'jenisTransaksi' => null,
                'keterangan' => $pinjaman->keterangan,
                'tenor' => $pinjaman->tenor,
                'tanggal_jatuh_tempo' => $pinjaman->tanggal_jatuh_tempo,
            ];
        });

        // gabungan transaksi buat riwayat
        $semuaTransaksi = $transaksiTabungan
            ->concat($transaksiPeminjaman)
            ->sortByDesc('tanggal_transaksi')
            ->values();

        // total setoran
        $totalPemasukan = $transaksiTabungan
            ->filter(function ($trx) {
                return $trx->jenisTransaksi
                    && $trx->jenisTransaksi->id_jenis_transaksi == 1;
            })
            ->sum('jumlah');

        // total penarikan
        $totalPengeluaran = $transaksiTabungan
            ->filter(function ($trx) {
                return $trx->jenisTransaksi
                    && $trx->jenisTransaksi->id_jenis_transaksi == 2;
            })
            ->sum('jumlah');

        // pagnition manual
        $perPage = 5;

        $currentPage = (int) $request->input('page', 1);

        $items = $semuaTransaksi
            ->slice(
                ($currentPage - 1) * $perPage,
                $perPage
            )
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

        // kirim data ke riwayat
        return view('nasabah.riwayat', compact(
            'transaksi',
            'totalPemasukan',
            'totalPengeluaran'
        ));
    }
}