<?php

namespace App\Http\Controllers;

use App\Models\RekeningTabungan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NasabahPenarikanController extends Controller
{
    public function create()
    {
        $user = auth()->user();
        $rekening = RekeningTabungan::where('id_nasabah', $user->nasabah->id_nasabah)->first();
        return view('nasabah.penarikan.create', compact('rekening'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $rekening = RekeningTabungan::where('id_nasabah', $user->nasabah->id_nasabah)->first();

        $request->validate([
            'jumlah' => 'required|numeric|min:10000',
            'keterangan' => 'required|string|max:255',
        ], [
            'jumlah.min' => 'Minimal penarikan adalah Rp 10.000',
        ]);

        // Cek saldo cukup (hanya untuk validasi tampilan, saldo belum dipotong)
        if ($rekening->saldo < $request->jumlah) {
            return back()->with('error', 'Saldo Anda tidak mencukupi. Saldo saat ini: Rp ' . number_format($rekening->saldo, 0, ',', '.'))->withInput();
        }

        DB::beginTransaction();
        try {
            // SIMPAN SEBAGAI PENDING (Saldo belum berkurang)
            Transaksi::create([
                'user_id' => $user->id,
                'jenis' => 'penarikan',
                'jumlah' => $request->jumlah,
                'keterangan' => $request->keterangan,
                'status' => 'pending', // ← KUNCI UTAMA
                'operator_id' => null,
            ]);

            DB::commit();
            return redirect()->route('nasabah.penarikan.create')
                ->with('success', 'Pengajuan penarikan Rp ' . number_format($request->jumlah, 0, ',', '.') . ' berhasil dikirim! Menunggu verifikasi operator.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengajukan: ' . $e->getMessage())->withInput();
        }
    }
}