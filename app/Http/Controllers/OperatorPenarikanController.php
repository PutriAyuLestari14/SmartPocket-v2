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

    // Memproses data "Simpan"
    public function store(Request $request)
    {
        $request->validate([
            'id_nasabah' => 'required|exists:nasabah,id_nasabah',
            'jumlah' => 'required|numeric|min:1000',
            'keterangan' => 'required|string|max:255',
        ], [
            'jumlah.min' => 'Minimal penarikan adalah Rp 1.000',
        ]);

        // jika ada 1 langkah yang gagal, semua perubahan dibatalkan (jadi data ga ada yg rusak)    
        DB::beginTransaction();
        try {

            // cari rek 
            $rekening = RekeningTabungan::where('id_nasabah', $request->id_nasabah)->first();
            
            if (!$rekening) {
                return back()->with('error', 'Nasabah belum memiliki rekening tabungan')->withInput();
            }

            if ($rekening->saldo < $request->jumlah) {
                return back()->with('error', 'Saldo nasabah tidak mencukupi. Saldo saat ini: Rp ' . number_format($rekening->saldo, 0, ',', '.'))->withInput();
            }

            // potong saldo
            $rekening->saldo -= $request->jumlah;
            $rekening->save();

            DetailTabungan::create([
                'no_rek' => $rekening->no_rek,
                'id_petugas' => auth()->id(),
                'id_jenis_transaksi' => 2, 
                'jumlah' => $request->jumlah,
                'tanggal_transaksi' => now()->timezone('Asia/Jakarta'),
                'status' => 'berhasil',
            ]);

            // simpen perubahan
            DB::commit();
            return redirect()->route('operator.penarikan.create')
                ->with('success', 'Penarikan berhasil! Saldo a.n ' . $rekening->nasabah->nama . ' berkurang sebesar Rp ' . number_format($request->jumlah, 0, ',', '.'));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
}