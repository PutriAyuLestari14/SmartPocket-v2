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
        $nasabah = Nasabah::with(['user', 'rekening'])
            ->where('status', 'aktif')
            ->orderBy('nama', 'asc')
            ->get();

        return view('operator.setoran.create', compact('nasabah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_nasabah' => 'required|exists:nasabah,id_nasabah',
            'jumlah' => 'required|numeric|min:1000',
            'keterangan' => 'required|string|max:255',
        ], [
            'jumlah.min' => 'Minimal setoran adalah Rp 1.000',
        ]);

        DB::beginTransaction();
        try {
            $rekening = RekeningTabungan::where('id_nasabah', $request->id_nasabah)->first();

            if (!$rekening) {
                return back()->with('error', 'Nasabah belum memiliki rekening tabungan')->withInput();
            }

            // Update Saldo 
            $rekening->increment('saldo', $request->jumlah);

            $jenisTransaksi = DB::table('jenis_transaksi')
                ->whereNotNull('setoran')
                ->first();

            if (!$jenisTransaksi) {
                DB::rollBack();
                return back()->with('error', 'Jenis transaksi Setoran tidak ditemukan di database')->withInput();
            }

            // Simpan ke Detail Tabungan
            DetailTabungan::create([
                'no_rek' => $rekening->no_rek,
                'id_petugas' => auth()->user()->username,
                'id_jenis_transaksi' => $jenisTransaksi->id_jenis_transaksi,
                'jumlah' => $request->jumlah,
                'status' => 'berhasil',
                'tanggal_transaksi' => now()->timezone('Asia/Jakarta'),
                'keterangan' => $request->keterangan,
            ]);

            DB::commit();

            $namaNasabah = $rekening->nasabah ? $rekening->nasabah->nama : 'Nasabah';

            return redirect()->route('operator.setoran.create')
                ->with('success', 'Berhasil! Setoran Rp ' . number_format($request->jumlah, 0, ',', '.') . ' untuk a.n ' . $namaNasabah);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage())->withInput();
        }
    }
}