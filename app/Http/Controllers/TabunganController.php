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
        // Berhasil dan gagal tampil, pending tidak tampil
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
        // Pending tidak tampil
        $transaksiPeminjaman = Peminjaman::where(
            'id_nasabah',
            $id_nasabah
        )
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
        $idPinjamanList = Peminjaman::where(
            'id_nasabah',
            $id_nasabah
        )->pluck('id_pinjaman');

        $transaksiAngsuran = Angsuran::whereIn(
            'id_pinjaman',
            $idPinjamanList
        )
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
        // Yang paling baru selalu berada di paling atas
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
            $pengajuanPenarikan = DetailTabungan::where(
                'no_rek',
                $rekening->no_rek
            )
            ->where('id_jenis_transaksi', 2)
            ->where('status', 'pending')
            ->latest('created_at')
            ->first();
        }

        // Pengajuan peminjaman yang masih pending
        $pengajuanPeminjaman = Peminjaman::where(
            'id_nasabah',
            $id_nasabah
        )
        ->where('status_verifikasi', 'pending')
        ->latest('created_at')
        ->first();

        $pinjamanAktif = Peminjaman::where('id_nasabah', $id_nasabah)
            ->where('status_verifikasi', 'disetujui')
            ->where('sisa_pinjaman', '>', 0)
            ->orderBy('tanggal_jatuh_tempo', 'asc')
            ->first();

        // ==========================================
        // PERBAIKAN: Pisah hitungan Pokok dan Bunga
        // ==========================================
        $totalSisaPokok = Peminjaman::where('id_nasabah', $id_nasabah)
            ->where('status_verifikasi', 'disetujui')
            ->where('sisa_pinjaman', '>', 0)
            ->sum('sisa_pinjaman') ?? 0;

        $totalSisaBunga = Peminjaman::where('id_nasabah', $id_nasabah)
            ->where('status_verifikasi', 'disetujui')
            ->where('sisa_pinjaman', '>', 0)
            ->sum('sisa_bunga') ?? 0;

        $totalKewajiban = $totalSisaPokok + $totalSisaBunga;

        return view('nasabah.dashboard', compact(
            'rekening',
            'transaksiTerbaru',
            'pengajuanPenarikan',
            'pengajuanPeminjaman',
            'pinjamanAktif',
            'totalSisaPokok',      // <-- Baru
            'totalSisaBunga',      // <-- Baru
            'totalKewajiban'       // <-- Baru
        ));
    
    }

    public function riwayat(Request $request)
    {
        $user = auth()->user();
        $idNasabah = $user->nasabah->id_nasabah;

        // 1. Setoran dan penarikan yang sudah diproses
        // Berhasil dan gagal tampil
        // Pending tidak tampil
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
                'sub_tipe' => $trx->id_jenis_transaksi == 1
                    ? 'Setoran'
                    : 'Penarikan',
                'id_jenis_transaksi' => $trx->id_jenis_transaksi,
                'tanggal_transaksi' => $trx->tanggal_transaksi,
                'jumlah' => $trx->jumlah,
                'status' => $trx->status,
                'keterangan' => $trx->keterangan ?? '-',
                'jenisTransaksi' => $trx->jenisTransaksi,
            ];
        });

        // 2. Pinjaman yang sudah diproses
        // Disetujui dan ditolak tampil
        // Pending tidak tampil
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
        $idPinjamanList = Peminjaman::where(
            'id_nasabah',
            $idNasabah
        )->pluck('id_pinjaman');

        $transaksiAngsuran = Angsuran::whereIn(
            'id_pinjaman',
            $idPinjamanList
        )
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
        // Transaksi terbaru selalu di atas
        $semuaTransaksi = $transaksiTabungan
            ->concat($transaksiPeminjaman)
            ->concat($transaksiAngsuran)
            ->sortByDesc(function ($trx) {
                return $trx->tanggal_transaksi;
            })
            ->values();

        // Total pemasukan
        // Hanya SETORAN yang berhasil
        $totalPemasukan = $transaksiTabungan
            ->filter(function ($trx) {
                return $trx->sub_tipe === 'Setoran'
                    && $trx->status === 'berhasil';
            })
            ->sum('jumlah');

        // Total pengeluaran
        // Hanya PENARIKAN yang berhasil
        // Penarikan gagal tidak dihitung
        $totalPengeluaran = $transaksiTabungan
            ->filter(function ($trx) {
                return $trx->sub_tipe === 'Penarikan'
                    && $trx->status === 'berhasil';
            })
            ->sum('jumlah');

        // Pagination manual
        $perPage = 10;
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

        return view('nasabah.riwayat', compact(
            'transaksi',
            'totalPemasukan',
            'totalPengeluaran'
        ));
    }
}