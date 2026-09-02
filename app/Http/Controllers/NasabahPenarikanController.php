<?php

namespace App\Http\Controllers;

use App\Models\RekeningTabungan;
use App\Models\DetailTabungan; // ← GANTI DARI Transaksi JADI DetailTabungan
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
            DetailTabungan::create([
                'no_rek' => $rekening->no_rek,
                'id_petugas' => null,
                'id_jenis_transaksi' => 2, // sesuaikan ID jenis transaksi
                'jumlah' => $request->jumlah,
                'status' => 'pending', // sekarang bisa pakai status!
                'tanggal_transaksi' => now(),
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