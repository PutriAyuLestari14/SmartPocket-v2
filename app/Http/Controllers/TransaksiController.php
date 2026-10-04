<?php

namespace App\Http\Controllers;

use App\Models\DetailTabungan;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class TransaksiController extends Controller
{
    // method buat nampilin daftar transaksi di sisi operator
    public function index(Request $request)
    {
        // ambil transaksi tabungan yang bukan pending
        $query = DetailTabungan::with(['jenisTransaksi', 'rekening.nasabah'])
            ->where('status', '!=', 'pending');

        // filter tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_transaksi', $request->tanggal);
        }

        $detailTabungan = $query
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        // transaksi tabungan biasa
        $transaksiTabungan = $detailTabungan->filter(function ($item) {
            return in_array((int) $item->id_jenis_transaksi, [1, 2]);
        });

        // buat data pendapatan lain-lain dari biaya buku
        $transaksiPendapatan = $detailTabungan
            ->filter(function ($item) {
                $keterangan = strtolower($item->keterangan ?? '');

                return (int) $item->id_jenis_transaksi === 1
                    && $item->status === 'berhasil'
                    && str_contains($keterangan, 'buku tabungan');
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

        // filter jenis transaksi
        if ($request->jenis === 'setoran') {
            $semuaTransaksi = $transaksiTabungan->filter(function ($item) {
                return (int) $item->id_jenis_transaksi === 1;
            });
        } elseif ($request->jenis === 'penarikan') {
            $semuaTransaksi = $transaksiTabungan->filter(function ($item) {
                return (int) $item->id_jenis_transaksi === 2;
            });
        } elseif ($request->jenis === 'pendapatan_lain_lain') {
            $semuaTransaksi = $transaksiPendapatan;
        } else {
            $semuaTransaksi = $transaksiTabungan->concat($transaksiPendapatan);
        }

        // urutkan transaksi dari yang paling baru
        $semuaTransaksi = $semuaTransaksi
            ->sortByDesc(function ($item) {
                return $item->tanggal_transaksi;
            })
            ->values();

        // pagination manual karena data pendapatan dibuat dari collection
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

        return view('operator.transaksi.index', compact('transaksi'));
    }
}