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
        // ambil nasabah aktif + relasi user & rekening
        // urut dari nama a-z
        $nasabah = Nasabah::with(['user', 'rekening'])
            ->where('status', 'aktif')
            ->orderBy('nama', 'asc')
            ->get();

        // kirim ke view
        return view('operator.setoran.create', compact('nasabah'));
    }

    // proses simpan setoran
    public function store(Request $request)
    {
        // validasi input: id_nasabah harus ada, jumlah min 1rb, ket wajib
        $request->validate([
            'id_nasabah' => 'required|exists:nasabah,id_nasabah',
            'jumlah' => 'required|numeric|min:1000',
            'keterangan' => 'required|string|max:255',
        ], [
            'jumlah.min' => 'Minimal setoran adalah Rp 1.000',
        ]);

        // mulai transaksi database
        DB::beginTransaction();
        try {
            // cari rekening nasabah
            $rekening = RekeningTabungan::where('id_nasabah', $request->id_nasabah)->first();

            // kalau gak ada rekening, balikin
            if (!$rekening) {
                return back()->with('error', 'Nasabah belum memiliki rekening tabungan')->withInput();
            }

            // tambah saldo nasabah (increment = +) disini lah gais
            $rekening->increment('saldo', $request->jumlah);

            // cari jenis transaksi setoran di tabel jenis_transaksi
            $jenisTransaksi = DB::table('jenis_transaksi')
                ->whereNotNull('setoran')
                ->first();

            // kalau jenis transaksi setoran gak ketemu, batalkan
            if (!$jenisTransaksi) {
                DB::rollBack();
                return back()->with('error', 'Jenis transaksi Setoran tidak ditemukan di database')->withInput();
            }

            // catat transaksi setoran di detail tabungan
            DetailTabungan::create([
                'no_rek' => $rekening->no_rek,
                'id_petugas' => auth()->user()->petugas->id_petugas,
                'id_jenis_transaksi' => $jenisTransaksi->id_jenis_transaksi,
                'jumlah' => $request->jumlah,
                'status' => 'berhasil', // langsung berhasil karena diproses teller
                'tanggal_transaksi' => now()->timezone('Asia/Jakarta'),
                'keterangan' => $request->keterangan,
            ]);

            // simpan permanen
            DB::commit();

            // ambil nama nasabah buat pesan sukses
            $namaNasabah = $rekening->nasabah ? $rekening->nasabah->nama : 'Nasabah';

            // balikin ke form dengan pesan sukses
            return redirect()->route('operator.setoran.create')
                ->with('success', 'Berhasil! Setoran Rp ' . number_format($request->jumlah, 0, ',', '.') . ' untuk a.n ' . $namaNasabah);

        } catch (\Exception $e) {
            // kalau error, batalkan semua perubahan
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage())->withInput();
        }
    }
}