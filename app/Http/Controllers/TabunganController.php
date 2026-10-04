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
    // method buat nampilin dashboard nasabah
    public function index()
    {
        // user yang lagi login
        $user = auth()->user();

        // id nasabah dari user
        $id_nasabah = $user->nasabah->id_nasabah;

        // rekening milik nasabah ini
        $rekening = RekeningTabungan::where('id_nasabah', $id_nasabah)->first();

        // transaksi tabungan (setoran/penarikan)
        // cuma yang berhasil & gagal, pending gak muncul
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

        // peminjaman yang udah diproses (disetujui/ditolak)
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

        // id semua pinjaman nasabah ini
        $idPinjamanList = Peminjaman::where(
            'id_nasabah',
            $id_nasabah
        )->pluck('id_pinjaman');

        // angsuran dari pinjaman-pinjaman itu
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

        // gabung semua, urut dari yang paling baru, ambil 5
        $transaksiTerbaru = $transaksiTabungan
            ->concat($transaksiPeminjaman)
            ->concat($transaksiAngsuran)
            ->sortByDesc(function ($trx) {
                return $trx->tanggal_transaksi;
            })
            ->take(5)
            ->values();

        // pengajuan penarikan yang masih pending
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

        // pengajuan peminjaman yang masih pending
        $pengajuanPeminjaman = Peminjaman::where(
            'id_nasabah',
            $id_nasabah
        )
        ->where('status_verifikasi', 'pending')
        ->latest('created_at')
        ->first();

        // pinjaman aktif (disetujui & sisa > 0)
        $pinjamanAktif = Peminjaman::where('id_nasabah', $id_nasabah)
            ->where('status_verifikasi', 'disetujui')
            ->where('sisa_pinjaman', '>', 0)
            ->orderBy('tanggal_jatuh_tempo', 'asc')
            ->first();

        // total sisa pokok semua pinjaman aktif
        $totalSisaPokok = Peminjaman::where('id_nasabah', $id_nasabah)
            ->where('status_verifikasi', 'disetujui')
            ->where('sisa_pinjaman', '>', 0)
            ->sum('sisa_pinjaman') ?? 0;

        // total sisa jasa (bunga)
        $totalSisaJasa = Peminjaman::where('id_nasabah', $id_nasabah)
            ->where('status_verifikasi', 'disetujui')
            ->where('sisa_pinjaman', '>', 0)
            ->sum('sisa_jasa') ?? 0;

        // total kewajiban = pokok + jasa
        $totalKewajiban = $totalSisaPokok + $totalSisaJasa;

        // kirim ke view dashboard nasabah
        return view('nasabah.dashboard', compact(
            'rekening',
            'transaksiTerbaru',
            'pengajuanPenarikan',
            'pengajuanPeminjaman',
            'pinjamanAktif',
            'totalSisaPokok',
            'totalSisaJasa',
            'totalKewajiban'
        ));
    }

    // method buat nampilin riwayat transaksi nasabah
    public function riwayat(Request $request)
    {
        // user yang lagi login
        $user = auth()->user();
        $idNasabah = $user->nasabah->id_nasabah;

        $kategori = strtolower(trim($user->nasabah->kategori));
        $isSiswa = $kategori === 'siswa';

        // transaksi tabungan (setoran/penarikan)
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

        // peminjaman yang udah diproses
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

        // id pinjaman nasabah ini
        $idPinjamanList = Peminjaman::where(
            'id_nasabah',
            $idNasabah
        )->pluck('id_pinjaman');

        // angsuran dari pinjaman itu
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

        // gabung semua, urut paling baru
       if ($isSiswa) {
            $semuaTransaksi = $transaksiTabungan;
        } else {
            $semuaTransaksi = $transaksiTabungan
                ->concat($transaksiPeminjaman)
                ->concat($transaksiAngsuran);
        }

        $semuaTransaksi = $semuaTransaksi
            ->sortByDesc(function ($trx) {
                return $trx->tanggal_transaksi;
            })
            ->values();

        // total pemasukan = setoran yang berhasil
        $totalPemasukan = $transaksiTabungan
            ->filter(function ($trx) {
                return $trx->sub_tipe === 'Setoran'
                    && $trx->status === 'berhasil';
            })
            ->sum('jumlah');

        // total pengeluaran = penarikan yang berhasil
        $totalPengeluaran = $transaksiTabungan
            ->filter(function ($trx) {
                return $trx->sub_tipe === 'Penarikan'
                    && $trx->status === 'berhasil';
            })
            ->sum('jumlah');

        // pagination manual, 10 per halaman
        $perPage = 10;
        $currentPage = (int) $request->input('page', 1);

        // potong data sesuai halaman
        $items = $semuaTransaksi
            ->slice(
                ($currentPage - 1) * $perPage,
                $perPage
            )
            ->values();

        // bikin paginator manual
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

        // kirim ke view riwayat
        return view('nasabah.riwayat', compact(
            'transaksi',
            'totalPemasukan',
            'totalPengeluaran',
            'isSiswa'
        ));
    }
}