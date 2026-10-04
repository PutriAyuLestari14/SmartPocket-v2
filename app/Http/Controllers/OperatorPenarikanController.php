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
        // ambil semua nasabah aktif + relasi user & rekeningnya
        // urut dari nama a-z
        $nasabah = Nasabah::with(['user', 'rekening'])
            ->where('status', 'aktif')
            ->orderBy('nama', 'asc')
            ->get();

        // kirim ke view
        return view('operator.penarikan.create', compact('nasabah'));
    }

    // proses simpan penarikan
    public function store(Request $request)
    {
        // validasi input: id_nasabah harus ada di tabel, jumlah min 1rb, ket wajib
        $request->validate([
            'id_nasabah' => 'required|exists:nasabah,id_nasabah',
            'jumlah' => 'required|numeric|min:1000',
            'keterangan' => 'required|string|max:255',
        ], [
            'jumlah.min' => 'Minimal penarikan adalah Rp 1.000',
        ]);

        // mulai transaksi, kalau ada 1 aja yang gagal semua dibatalin
        DB::beginTransaction();
        try {

            // cari rekening nasabah yang mau ditarik
            $rekening = RekeningTabungan::where('id_nasabah', $request->id_nasabah)->first();
            
            // kalau rekening gak ada, balikin
            if (!$rekening) {
                return back()->with('error', 'Nasabah belum memiliki rekening tabungan')->withInput();
            }

            // tentukan saldo mengendap
            $saldoMengendap = 10000;

            // cek apakah saldo nasabah mencukupi untuk penarikan
            if ($rekening->saldo < $request->jumlah) {
                DB::rollBack();

                return back()
                    ->with('error', 'Saldo nasabah tidak mencukupi. Saldo saat ini: Rp ' . number_format($rekening->saldo, 0, ',', '.'))
                    ->withInput();
            }

            // hitung maksimal penarikan
            $maksimalPenarikan = $rekening->saldo - $saldoMengendap;

            // cek apakah saldo masih memungkinkan untuk ditarik
            if ($maksimalPenarikan < 1000) {
                DB::rollBack();

                return back()
                    ->with('error', 'Penarikan tidak dapat dilakukan. Saldo minimal yang harus mengendap adalah Rp 10.000.')
                    ->withInput();
            }

            // cek apakah jumlah penarikan melebihi batas
            if ($request->jumlah > $maksimalPenarikan) {
                DB::rollBack();

                return back()
                    ->with('error', 'Maksimal penarikan adalah Rp ' . number_format($maksimalPenarikan, 0, ',', '.') . '. Saldo mengendap Rp 10.000 harus tetap tersisa.')
                    ->withInput();
            }

            // potong saldo nasabah di sinilah gais 
            $rekening->saldo -= $request->jumlah;
            $rekening->save();

            // catat transaksi penarikan di detail tabungan
            DetailTabungan::create([
                'no_rek' => $rekening->no_rek,
                'id_petugas' => auth()->user()->petugas->id_petugas,
                'id_jenis_transaksi' => 2, // 2 = penarikan
                'jumlah' => $request->jumlah,
                'tanggal_transaksi' => now()->timezone('Asia/Jakarta'),
                'status' => 'berhasil', // langsung berhasil karena diproses teller
            ]);

            // simpan permanen
            DB::commit();

            // balikin ke form dengan pesan sukses
            return redirect()->route('operator.penarikan.create')
                ->with('success', 'Penarikan berhasil! Saldo a.n ' . $rekening->nasabah->nama . ' berkurang sebesar Rp ' . number_format($request->jumlah, 0, ',', '.'));

        } catch (\Exception $e) {
            // kalau error, batalkan semua perubahan
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
}