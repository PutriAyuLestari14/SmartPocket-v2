<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\RekeningTabungan;
use App\Models\DetailTabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OperatorSetoranController extends Controller
{
    public function create()
    {
        return view('operator.setoran.create');
    }

    // Cari Nasabah 
    public function searchNasabah(Request $request)
    {
        $keyword = $request->get('q');
        
        $nasabah = Nasabah::with(['user', 'rekening'])
            ->where('status', 'aktif')
            ->where(function($query) use ($keyword) {
                $query->where('nama', 'like', "%{$keyword}%")
                      ->orWhereHas('user', function($u) use ($keyword) {
                          $u->where('username', 'like', "%{$keyword}%");
                      });
            })->first();

        return response()->json($nasabah);
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_rek' => 'required|exists:rekening_tabungan,no_rek',
            'jumlah' => 'required|numeric|min:1000', 
            'tanggal_transaksi' => 'required|date',
        ]);

        DB::beginTransaction();
        try {
            // 1. Update Saldo Rekening
            $rekening = RekeningTabungan::where('no_rek', $request->no_rek)->first();
            $rekening->saldo += $request->jumlah;
            $rekening->save();

            // 2. Simpan ke Detail Tabungan
            DetailTabungan::create([
                'no_rek' => $request->no_rek,
                'id_petugas' => auth()->id(), 
                'id_jenis_transaksi' => 1, 
                'jumlah' => $request->jumlah,
                'tanggal_transaksi' => $request->tanggal_transaksi,
            ]);

            DB::commit();

            return redirect()->route('operator.setoran.create')
                ->with('success', 'Setoran sebesar Rp ' . number_format($request->jumlah, 0, ',', '.') . ' berhasil diproses!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal memproses setoran: ' . $e->getMessage()])->withInput();
        }
    }
}