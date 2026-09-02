<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\RekeningTabungan;
use App\Models\DetailTabungan;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    public function index()
    {
        $totalNasabah = Nasabah::count();
        $totalSaldo = RekeningTabungan::sum('saldo');

        $transaksiHariIni = DetailTabungan::whereDate('tanggal_transaksi', today())->count();
        
        $transaksiMingguIni = DetailTabungan::whereBetween('tanggal_transaksi', [
            now()->startOfWeek(), 
            now()->endOfWeek()
        ])->count();   
        
        $penarikanPending = 0; 

        $transaksiTerkini = DetailTabungan::with(['jenisTransaksi', 'rekening.nasabah'])
            ->orderBy('tanggal_transaksi', 'desc')
            ->take(8)
            ->get();

        // whereHas untuk filter lewattabel 'jenis'
        $totalSetoranBulanIni = DetailTabungan::whereMonth('tanggal_transaksi', now()->month)
            ->whereHas('jenisTransaksi', function($q) {
                $q->where('setoran', 'setoran');
            })->sum('jumlah');
                                         
        $totalPenarikanBulanIni = DetailTabungan::whereMonth('tanggal_transaksi', now()->month)
            ->whereHas('jenisTransaksi', function($q) {
                $q->where('setoran', 'penarikan');
            })->sum('jumlah');

        return view('operator.dashboard', [
            'totalNasabah' => $totalNasabah,
            'totalSaldo' => $totalSaldo,
            'transaksiHariIni' => $transaksiHariIni,
            'transaksiMingguIni' => $transaksiMingguIni,
            'penarikanPending' => $penarikanPending,
            'transaksiTerkini' => $transaksiTerkini,
            'totalSetoranBulanIni' => $totalSetoranBulanIni,
            'totalPenarikanBulanIni' => $totalPenarikanBulanIni,
        ]);
    }
}