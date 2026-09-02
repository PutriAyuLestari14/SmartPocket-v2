<?php

namespace App\Http\Controllers;

use App\Models\RekeningTabungan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TabunganController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Ambil data rekening nasabah
        $rekening = RekeningTabungan::where('id_nasabah', $user->nasabah->id_nasabah)->first();
        
        // Ambil 5 transaksi terbaru
        $transaksiTerbaru = Transaksi::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('nasabah.dashboard', compact('rekening', 'transaksiTerbaru'));
    }

    public function riwayat()
    {
        $user = auth()->user();
        
        // Ambil semua transaksi dengan pagination
        $transaksi = Transaksi::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('nasabah.riwayat', compact('transaksi'));
    }
}