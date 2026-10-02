<?php

namespace App\Http\Controllers;

use App\Models\DetailTabungan;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    // method buat nampilin daftar transaksi di sisi operator
    public function index(Request $request)
    {
        // query ke detail tabungan + relasinya
        // jangan tampilkan yang pending, urut dari yang paling baru
        $query = DetailTabungan::with(['jenisTransaksi', 'rekening.nasabah'])
            ->where('status', '!=', 'pending')
            ->orderBy('tanggal_transaksi', 'desc');

        // filter jenis (setoran/penarikan)
        if ($request->filled('jenis')) {
            if ($request->jenis === 'setoran') {
                $query->where('id_jenis_transaksi', 1);
            } elseif ($request->jenis === 'penarikan') {
                $query->where('id_jenis_transaksi', 2);
            }
        }

        // filter tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_transaksi', $request->tanggal);
        }

        // pagination 10 per halaman
        $transaksi = $query->paginate(10);

        // kirim ke view
        return view('operator.transaksi.index', compact('transaksi'));
    }
}