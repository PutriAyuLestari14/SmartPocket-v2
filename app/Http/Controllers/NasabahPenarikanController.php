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

        $saldoMengendap = 10000;

        $request->validate([
            'jumlah' => 'required|numeric|min:10000',
            'tanggal_transaksi' => 'required|date',
            'keterangan' => 'required|string|max:255',
        ], [
            'jumlah.min' => 'Minimal penarikan adalah Rp 10.000',
            'tanggal_transaksi.required' => 'Tanggal penarikan wajib diisi.',
        ]);

        if (!$rekening) {
            return back()->with('error', 'Rekening tabungan tidak ditemukan.')->withInput();
        }

        $maksimalPenarikan = max(0, $rekening->saldo - $saldoMengendap);

        if ($request->jumlah > $maksimalPenarikan) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Penarikan melebihi batas. Saldo mengendap Rp ' .
                    number_format($saldoMengendap, 0, ',', '.') .
                    ' harus tetap tersimpan. Maksimal penarikan Anda adalah Rp ' .
                    number_format($maksimalPenarikan, 0, ',', '.') . '.'
                );
        }

        DB::beginTransaction();

        try {
            DetailTabungan::create([
                'no_rek' => $rekening->no_rek,
                'id_petugas' => null,
                'id_jenis_transaksi' => 2,
                'jumlah' => $request->jumlah,
                'tanggal_transaksi' => now()->timezone('Asia/Jakarta'),
                'keterangan' => $request->keterangan,
                'status' => 'pending',
            ]);

            DB::commit();

            return redirect()->route('nasabah.penarikan.create')
                ->with(
                    'success',
                    'Pengajuan penarikan Rp ' .
                    number_format($request->jumlah, 0, ',', '.') .
                    ' berhasil dikirim! Menunggu verifikasi operator.'
                );

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->with('error', 'Gagal mengajukan: ' . $e->getMessage())
                ->withInput();
        }
    }
}