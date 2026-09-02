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
            $rekening->saldo += $request->jumlah;
            $rekening->save();

            // Cari ID Jenis Transaksi untuk Setoran
            $jenisTransaksi = DB::table('jenis_transaksi')
                ->where('setoran', 'setoran')
                ->first();

            if (!$jenisTransaksi) {
                return back()->with('error', 'Jenis transaksi Setoran tidak ditemukan')->withInput();
            }

            // Simpan ke Detail Tabungan
            DetailTabungan::create([
                'no_rek' => $rekening->no_rek,
                'id_petugas' => auth()->id(),
                'id_jenis_transaksi' => $jenisTransaksi->id_jenis_transaksi,
                'jumlah' => $request->jumlah,
                'tanggal_transaksi' => now(),
            ]);

            DB::commit();

            return redirect()->route('operator.setoran.create')
                ->with('success', 'Setoran Rp ' . number_format($request->jumlah, 0, ',', '.') . ' berhasil untuk a.n ' . $rekening->nasabah->nama);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage())->withInput();
        }
    }
}