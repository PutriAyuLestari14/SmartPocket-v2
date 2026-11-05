<?php

namespace App\Http\Controllers;

use App\Models\DetailTabungan;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class TransaksiController extends Controller
{
    // Menampilkan daftar transaksi di sisi operator.
    public function index(Request $request)
    {
        // Ambil transaksi yang bukan pending.
        $query = DetailTabungan::with([
            'jenisTransaksi',
            'rekening.nasabah'
        ])->where('status', '!=', 'pending');

        // Filter tanggal.
        if ($request->filled('tanggal')) {
            $query->whereDate(
                'tanggal_transaksi',
                $request->tanggal
            );
        }

        $detailTabungan = $query
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        // Transaksi tabungan biasa.
        // Semua transaksi biaya buku dikeluarkan dari
        // kategori Setoran dan Penarikan.
        $transaksiTabungan = $detailTabungan->filter(
            function ($item) {
                $keterangan = strtolower(
                    trim($item->keterangan ?? '')
                );

                if (
                    str_contains(
                        $keterangan,
                        'biaya buku tabungan'
                    ) ||
                    str_contains(
                        $keterangan,
                        'pembayaran buku tabungan'
                    )
                ) {
                    return false;
                }

                return in_array(
                    (int) $item->id_jenis_transaksi,
                    [1, 2]
                );
            }
        );

        // Biaya buku tabungan masuk ke Pendapatan Lain-lain,
        // termasuk biaya yang dipotong langsung dari saldo.
        $transaksiPendapatan = $detailTabungan
            ->filter(function ($item) {
                $keterangan = strtolower(
                    trim($item->keterangan ?? '')
                );

                $adalahBiayaBuku =
                    str_contains(
                        $keterangan,
                        'biaya buku tabungan'
                    ) ||
                    str_contains(
                        $keterangan,
                        'pembayaran buku tabungan'
                    );

                return $item->status === 'berhasil'
                    && $adalahBiayaBuku;
            })
            ->map(function ($item) {
                return (object) [
                    'id' => 'buku-' . $item->id,
                    'id_jenis_transaksi' => null,
                    'jumlah' => 5000,
                    'tanggal_transaksi' =>
                        $item->tanggal_transaksi,
                    'status' => 'berhasil',
                    'keterangan' => 'Biaya Buku Tabungan',
                    'rekening' => $item->rekening,
                    'jenisTransaksi' => null,
                    'is_pendapatan_lain_lain' => true,
                ];
            });

        // Filter jenis transaksi.
        if ($request->jenis === 'setoran') {
            $semuaTransaksi = $transaksiTabungan->filter(
                function ($item) {
                    return (int) $item->id_jenis_transaksi === 1;
                }
            );
        } elseif ($request->jenis === 'penarikan') {
            $semuaTransaksi = $transaksiTabungan->filter(
                function ($item) {
                    return (int) $item->id_jenis_transaksi === 2;
                }
            );
        } elseif ($request->jenis === 'pendapatan_lain_lain') {
            $semuaTransaksi = $transaksiPendapatan;
        } else {
            $semuaTransaksi = $transaksiTabungan
                ->concat($transaksiPendapatan);
        }

        // Urutkan dari transaksi terbaru.
        $semuaTransaksi = $semuaTransaksi
            ->sortByDesc(function ($item) {
                return $item->tanggal_transaksi;
            })
            ->values();

        // Pagination manual.
        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $items = $semuaTransaksi
            ->slice(($currentPage - 1) * $perPage, $perPage)
            ->values();

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

        return view(
            'operator.transaksi.index',
            compact('transaksi')
        );
    }
}
