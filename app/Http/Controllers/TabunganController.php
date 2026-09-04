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
        
        $rekening = RekeningTabungan::where('id_nasabah', $user->nasabah->id_nasabah)->first();
        
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
    
    $baseQuery = DetailTabungan::whereHas('rekening.nasabah', function($query) use ($user) {
        $query->where('id_user', $user->id);
    })->with(['jenisTransaksi', 'rekening.nasabah']);

    $totalPemasukan = (clone $baseQuery)->whereHas('jenisTransaksi', function($q) {
        $q->where('setoran', 'setoran');
    })->sum('jumlah');

    $totalPengeluaran = (clone $baseQuery)->whereHas('jenisTransaksi', function($q) {
        $q->where('setoran', 'penarikan');
    })->sum('jumlah');

    $transaksi = $baseQuery->orderBy('tanggal_transaksi', 'desc')->paginate(10);

    return view('nasabah.riwayat', compact(
        'transaksi', 
        'totalPemasukan', 
        'totalPengeluaran'
    ));
}
}