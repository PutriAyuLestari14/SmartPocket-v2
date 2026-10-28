<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\RekeningTabungan;
use App\Models\DetailTabungan;
use App\Models\Peminjaman;
use App\Models\Angsuran;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class TabunganController extends Controller
{
    // Method untuk menampilkan dashboard nasabah
    public function index()
    {
        // User yang sedang login
        $user = auth()->user();

        // ID nasabah dari user
        $id_nasabah = $user->nasabah->id_nasabah;

        // Rekening milik nasabah
        $rekening = RekeningTabungan::where(
            'id_nasabah',
            $id_nasabah
        )->first();

        // Transaksi tabungan: hanya berhasil dan gagal
        $transaksiTabungan = DetailTabungan::whereHas(
            'rekening.nasabah',
            function ($query) use ($user) {
                $query->where('username', $user->username);
            }
        )            
            ->whereIn('status', ['berhasil', 'gagal'])
            ->where(function ($query) {
                $query->whereNull('keterangan')
                    ->orWhere(function ($q) {
                        $q->whereRaw(
                            'LOWER(keterangan) NOT LIKE ?',
                            ['%biaya buku tabungan%']
                        )->whereRaw(
                            'LOWER(keterangan) NOT LIKE ?',
                            ['%pembayaran buku tabungan%']
                        );
                    });
            })
            ->with('jenisTransaksi')
            ->get()

            ->map(function ($trx) {
                $keteranganAsli = strtolower(
                    trim($trx->keterangan ?? '')
                );

                if (str_contains($keteranganAsli, 'bagi hasil')) {
                    $subTipe = 'Bagi Hasil';
                } elseif (
                    str_contains($keteranganAsli, 'biaya buku tabungan') ||
                    str_contains($keteranganAsli, 'pembayaran buku tabungan')
                ) {
                    $subTipe = 'Pembayaran Buku Tabungan';
                } elseif ((int) $trx->id_jenis_transaksi === 1) {
                    $subTipe = 'Setoran';
                } else {
                    $subTipe = 'Penarikan';
                }

                return (object) [
                    'tipe' => 'tabungan',
                    'sub_tipe' => $subTipe,
                    'id_jenis_transaksi' => $trx->id_jenis_transaksi,
                    'tanggal_transaksi' => $trx->tanggal_transaksi,
                    'jumlah' => $trx->jumlah,
                    'status' => $trx->status,
                    'keterangan' => $trx->keterangan ?? '-',
                    'jenisTransaksi' => $trx->jenisTransaksi,
                ];
            });

        // Peminjaman yang sudah diproses
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

        // ID semua pinjaman nasabah
        $idPinjamanList = Peminjaman::where(
            'id_nasabah',
            $id_nasabah
        )->pluck('id_pinjaman');

        // Angsuran dari pinjaman nasabah
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

        // Gabungkan transaksi, urutkan terbaru, ambil 5
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

        // Pinjaman aktif
        $pinjamanAktif = Peminjaman::where('id_nasabah', $id_nasabah)
            ->where('status_verifikasi', 'disetujui')
            ->where('sisa_pinjaman', '>', 0)
            ->orderBy('tanggal_jatuh_tempo', 'asc')
            ->first();

        // Total sisa pokok pinjaman aktif
        $totalSisaPokok = Peminjaman::where('id_nasabah', $id_nasabah)
            ->where('status_verifikasi', 'disetujui')
            ->where('sisa_pinjaman', '>', 0)
            ->sum('sisa_pinjaman') ?? 0;

        // Total sisa jasa pinjaman aktif
        $totalSisaJasa = Peminjaman::where('id_nasabah', $id_nasabah)
            ->where('status_verifikasi', 'disetujui')
            ->where('sisa_pinjaman', '>', 0)
            ->sum('sisa_jasa') ?? 0;

        // Total kewajiban
        $totalKewajiban = $totalSisaPokok + $totalSisaJasa;

        // Kirim data ke dashboard nasabah
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

    // Method untuk menampilkan riwayat transaksi nasabah
    public function riwayat(Request $request)
    {
        // User yang sedang login
        $user = auth()->user();
        $idNasabah = $user->nasabah->id_nasabah;

        $kategori = strtolower(trim($user->nasabah->kategori ?? ''));
        $isSiswa = $kategori === 'siswa';

        // Transaksi tabungan
        
        // Transaksi tabungan nasabah
        $transaksiTabungan = DetailTabungan::whereHas(
            'rekening.nasabah',
            function ($query) use ($user) {
                $query->where('username', $user->username);
            }
        )
            ->whereIn('status', ['berhasil', 'gagal'])
            ->where(function ($query) {
                // Biaya buku bukan transaksi saldo nasabah.
                $query->whereNull('keterangan')
                    ->orWhere(function ($q) {
                        $q->whereRaw(
                            "LOWER(keterangan) NOT LIKE ?",
                            ['%biaya buku tabungan%']
                        )->whereRaw(
                            "LOWER(keterangan) NOT LIKE ?",
                            ['%pembayaran buku tabungan%']
                        );
                    });
            })
            ->with([
                'jenisTransaksi',
                'rekening.nasabah',
            ])
            ->get()

            ->map(function ($trx) {
                $keteranganAsli = strtolower(
                    trim($trx->keterangan ?? '')
                );


                if (str_contains($keteranganAsli, 'bagi hasil')) {
                    $subTipe = $trx->keterangan;
                } elseif (
                    str_contains($keteranganAsli, 'biaya buku tabungan') ||
                    str_contains($keteranganAsli, 'pembayaran buku tabungan')
                ) {
                    $subTipe = 'Pembayaran Buku Tabungan';
                } elseif ((int) $trx->id_jenis_transaksi === 1) {
                    $subTipe = 'Setoran';
                } else {
                    $subTipe = 'Penarikan';
                }


                return (object) [
                    'tipe' => 'tabungan',
                    'sub_tipe' => $subTipe,
                    'id_jenis_transaksi' => $trx->id_jenis_transaksi,
                    'tanggal_transaksi' => $trx->tanggal_transaksi,
                    'jumlah' => $trx->jumlah,
                    'status' => $trx->status,
                    'keterangan' => $trx->keterangan ?? '-',
                    'jenisTransaksi' => $trx->jenisTransaksi,
                ];
            });

        // Peminjaman yang sudah diproses
        $transaksiPeminjaman = Peminjaman::where(
            'id_nasabah',
            $idNasabah
        )
            ->whereIn('status_verifikasi', [
                'disetujui',
                'ditolak',
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

        // ID pinjaman milik nasabah
        $idPinjamanList = Peminjaman::where(
            'id_nasabah',
            $idNasabah
        )->pluck('id_pinjaman');

        // Angsuran pinjaman nasabah
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

        // Gabungkan transaksi sesuai kategori nasabah
        if ($isSiswa) {
            $semuaTransaksi = $transaksiTabungan;
        } else {
            $semuaTransaksi = $transaksiTabungan
                ->concat($transaksiPeminjaman)
                ->concat($transaksiAngsuran);
        }

        // Urutkan transaksi terbaru
        $semuaTransaksi = $semuaTransaksi
            ->sortByDesc(function ($trx) {
                return $trx->tanggal_transaksi;
            })
            ->values();

        // Total pemasukan: setoran dan bagi hasil yang berhasil
        $totalPemasukan = $transaksiTabungan
            ->filter(function ($trx) {
            return (
                $trx->sub_tipe === 'Setoran' ||
                str_contains(strtolower($trx->sub_tipe), 'bagi hasil')
            ) && $trx->status === 'berhasil';
            })
            ->sum('jumlah');

        // Total pengeluaran: penarikan yang berhasil
        $totalPengeluaran = $transaksiTabungan
            ->filter(function ($trx) {
                return $trx->sub_tipe === 'Penarikan'
                    && $trx->status === 'berhasil';
            })
            ->sum('jumlah');

        // Pagination manual, 10 transaksi per halaman
        $perPage = 10;
        $currentPage = max(1, (int) $request->input('page', 1));

        $items = $semuaTransaksi
            ->slice(($currentPage - 1) * $perPage, $perPage)
            ->values();

        // Paginator manual
        $transaksi = new LengthAwarePaginator(
            $items,
            $semuaTransaksi->count(),
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        // Kirim data ke halaman riwayat
        return view('nasabah.riwayat', compact(
            'transaksi',
            'totalPemasukan',
            'totalPengeluaran',
            'isSiswa'
        ));
    }
}
