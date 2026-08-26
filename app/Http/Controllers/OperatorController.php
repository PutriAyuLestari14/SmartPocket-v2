<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\RekeningTabungan;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    public function index()
    {
        // Ambil data untuk dashboard
        $totalNasabah = Nasabah::count();
        $totalSaldo = RekeningTabungan::sum('saldo');
        $pendingVerif = 3; // Nanti ganti dengan query yang bener
        $penarikanMenunggu = 8; // Nanti ganti dengan query yang bener
        
        return view('operator.dashboard', [
            'totalNasabah' => $totalNasabah,
            'totalSaldo' => $totalSaldo,
            'pendingVerif' => $pendingVerif,
            'penarikanMenunggu' => $penarikanMenunggu,
            'transaksiHariIni' => 156,
            'transaksiMingguIni' => 89,
        ]);
    }
}