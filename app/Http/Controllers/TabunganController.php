<?php

namespace App\Http\Controllers;

use App\Models\RekeningTabungan;
use App\Models\DetailTabungan;
use Illuminate\Http\Request;

class TabunganController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Ambil data rekening nasabah
        $rekening = RekeningTabungan::where('id_nasabah', $user->nasabah->id_nasabah)->first();
        
        // PERBAIKAN: whereHas('rekening.nasabah', ...) BUKAN whereHas('nasabah', ...)
        $transaksiTerbaru = DetailTabungan::whereHas('rekening.nasabah', function($query) use ($user) {
                $query->where('id_user', $user->id);
            })
            ->orderBy('tanggal_transaksi', 'desc')
            ->limit(5)
            ->get();

        return view('nasabah.dashboard', compact('rekening', 'transaksiTerbaru'));
    }

    public function riwayat()
    {
        $user = auth()->user();
        
        // PERBAIKAN: whereHas('rekening.nasabah', ...) BUKAN whereHas('nasabah', ...)
        $transaksi = DetailTabungan::whereHas('rekening.nasabah', function($query) use ($user) {
                $query->where('id_user', $user->id);
            })
            ->orderBy('tanggal_transaksi', 'desc')
            ->paginate(10);

        return view('nasabah.riwayat', compact('transaksi'));
    }
}