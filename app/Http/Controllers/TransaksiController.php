<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Nasabah;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        // Ambil semua transaksi dengan relasi user dan nasabah
        $transaksi = Transaksi::with(['user.nasabah', 'operator'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Kirim data nasabah untuk dropdown filter
        $nasabah = Nasabah::with('user')
            ->where('status', 'aktif')
            ->orderBy('nama', 'asc')
            ->get();

        return view('operator.transaksi.index', compact('transaksi', 'nasabah'));
    }
}