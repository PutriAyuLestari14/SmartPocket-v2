<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\RekeningTabungan;
use App\Models\DetailTabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OperatorPenarikanController extends Controller
{
    public function create()
    {
        $nasabah = Nasabah::with(['user', 'rekening'])
            ->where('status', 'aktif')
            ->orderBy('nama', 'asc')
            ->get();

        return view('operator.penarikan.create', compact('nasabah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_nasabah' => 'required|exists:nasabah,id_nasabah',
            'jumlah' => 'required|numeric|min:1000',
            'keterangan' => 'required|string|max:255',
        ], [
            'jumlah.min' => 'Minimal penarikan adalah Rp 1.000',
        ]);

        DB::beginTransaction();
        try {
            $rekening = RekeningTabungan::where('id_nasabah', $request->id_nasabah)->first();
            
            if (!$rekening) {
                return back()->with('error', 'Nasabah belum memiliki rekening tabungan')->withInput();
            }

            if ($rekening->saldo < $request->jumlah) {
                return back()->with('error', 'Saldo nasabah tidak mencukupi. Saldo saat ini: Rp ' . number_format($rekening->saldo, 0, ',', '.'))->withInput();
            }

            $rekening->saldo -= $request->jumlah;
            $rekening->save();

            DetailTabungan::create([
                'no_rek' => $rekening->no_rek,
                'id_petugas' => auth()->id(),
                'id_jenis_transaksi' => 2, 
                'jumlah' => $request->jumlah,
                'tanggal_transaksi' => now(),
            ]);

            DB::commit();
            return redirect()->route('operator.penarikan.create')
                ->with('success', 'Penarikan berhasil! Saldo a.n ' . $rekening->nasabah->nama . ' berkurang sebesar Rp ' . number_format($request->jumlah, 0, ',', '.'));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
}