<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\Angsuran;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminSaldoController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->periode ?? now()->format('Y-m');

        $tahun = Carbon::parse($periode . '-01')->year;
        $bulan = Carbon::parse($periode . '-01')->month;

        $totalJasa = Angsuran::whereYear('tanggal_pembayaran', $tahun)
            ->whereMonth('tanggal_pembayaran', $bulan)
            ->sum('jumlah_jasa');

        $nasabahs = Nasabah::with('rekening')
            ->orderBy('nama', 'asc')
            ->paginate(10)
            ->withQueryString();

        $totalBagiHasil = 0;
        $sudahDiproses = false;

        return view('admin.saldo.index', compact(
            'nasabahs',
            'periode',
            'totalJasa',
            'totalBagiHasil',
            'sudahDiproses'
        ));
    }
}