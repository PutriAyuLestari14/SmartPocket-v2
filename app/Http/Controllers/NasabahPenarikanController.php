<?php

namespace App\Http\Controllers;

use App\Models\RekeningTabungan;
use App\Models\DetailTabungan;
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

        // 1. TAMBAHKAN validasi untuk 'tanggal_transaksi'
        $request->validate([
            'jumlah' => 'required|numeric|min:10000',
            'tanggal_transaksi' => 'required|date', // ← TAMBAHAN BARU
            'keterangan' => 'required|string|max:255',
        ], [
            'jumlah.min' => 'Minimal penarikan adalah Rp 10.000',
            'tanggal_transaksi.required' => 'Tanggal penarikan wajib diisi.', // ← PESAN ERROR BARU
        ]);

        // Cek saldo cukup (hanya untuk validasi tampilan, saldo belum dipotong)
        if ($rekening->saldo < $request->jumlah) {
            return back()->with('error', 'Saldo Anda tidak mencukupi. Saldo saat ini: Rp ' . number_format($rekening->saldo, 0, ',', '.'))->withInput();
        }

        DB::beginTransaction();
        try {
            // 2. SIMPAN DATA KE DATABASE
            DetailTabungan::create([
                'no_rek' => $rekening->no_rek,
                'id_petugas' => null, // Tetap null, nanti diisi operator saat approve
                'id_jenis_transaksi' => 2, // ID untuk Penarikan
                'jumlah' => $request->jumlah, 
                'tanggal_transaksi' => now()->timezone('Asia/Jakarta'),
                'keterangan' => $request->keterangan, // ← TAMBAHAN: Simpan keterangan (sebelumnya lupa)
                'status' => 'pending', 
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