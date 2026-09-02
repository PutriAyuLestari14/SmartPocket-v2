<?php

namespace App\Http\Controllers;

use App\Models\DetailTabungan;
use App\Models\Nasabah;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        // PERBAIKAN: dengan(['rekening.nasabah.user']) bukan ['nasabah.user']
        $transaksi = DetailTabungan::with(['rekening.nasabah.user'])
            ->orderBy('tanggal_transaksi', 'desc')
            ->paginate(15);

        $nasabah = Nasabah::with('user')
            ->where('status', 'aktif')
            ->orderBy('nama', 'asc')
            ->get();

        return view('operator.transaksi.index', compact('transaksi', 'nasabah'));
    }
}