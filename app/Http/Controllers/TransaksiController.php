<?php

namespace App\Http\Controllers;

use App\Models\DetailTabungan;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = DetailTabungan::with(['jenisTransaksi', 'rekening.nasabah'])
            ->orderBy('tanggal_transaksi', 'desc');

        // Filter Jenis
        if ($request->filled('jenis')) {
            if ($request->jenis == 'setoran') {
                $query->whereHas('jenisTransaksi', fn($q) => $q->where('setoran', 'setoran'));
            } elseif ($request->jenis == 'penarikan') {
                $query->whereHas('jenisTransaksi', fn($q) => $q->where('setoran', 'penarikan'));
            }
        }

        // Filter Tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_transaksi', $request->tanggal);
        }

        $transaksi = $query->paginate(10);

        return view('operator.transaksi.index', compact('transaksi'));
    }
}