<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\RekeningTabungan;
use App\Models\DetailTabungan;
use Illuminate\Http\Request;

class TabunganController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Cari rekening punya user yang login
        $rekening = RekeningTabungan::where('id_nasabah', $user->nasabah->id_nasabah)->first();
        
        // 5 transaksi terbaru punya si user
        $transaksiTerbaru = DetailTabungan::whereHas('rekening.nasabah', function($query) use ($user) {
                $query->where('username', $user->username);
            })
            ->orderBy('tanggal_transaksi', 'desc')
            ->limit(5)
            ->get();

        return view('nasabah.dashboard', compact('rekening', 'transaksiTerbaru'));
    }

    public function riwayat(Request $request)
    {
        $user = auth()->user();
        
        // untuk ambil semua transaksi user ini
        $baseQuery = DetailTabungan::whereHas('rekening.nasabah', function($query) use ($user) {
            $query->where('username', $user->username);
        })->with(['jenisTransaksi', 'rekening.nasabah']);

        // Hitung total pemasukan (id_jenis_transaksi = 1 adalah Setoran)
        $totalPemasukan = (clone $baseQuery)->where('id_jenis_transaksi', 1)->sum('jumlah');

        // Hitung total pengeluaran (id_jenis_transaksi = 2 adalah Penarikan)
        $totalPengeluaran = (clone $baseQuery)->where('id_jenis_transaksi', 2)->sum('jumlah');

        $transaksi = $baseQuery->orderBy('tanggal_transaksi', 'desc')->paginate(10);

        return view('nasabah.riwayat', compact(
            'transaksi', 
            'totalPemasukan', 
            'totalPengeluaran'
        ));
    }
}