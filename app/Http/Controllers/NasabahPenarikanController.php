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

        // cari rekening milik nasabah yang login
        $rekening = RekeningTabungan::where('id_nasabah', $user->nasabah->id_nasabah)->first();

        // kirim data rekening ke view
        return view('nasabah.penarikan.create', compact('rekening'));
    }

    // proses simpan pengajuan penarikan
    public function store(Request $request)
    {
        // ambil user & rekening yang login
        $user = auth()->user();
        $rekening = RekeningTabungan::where('id_nasabah', $user->nasabah->id_nasabah)->first();

        // saldo minimum yang harus tetap ada di rekening
        $saldoMengendap = 10000;

        // validasi input dari form
        // jumlah minimal 10rb, tanggal & keterangan wajib
        $request->validate([
            'jumlah' => 'required|numeric|min:10000',
            'tanggal_transaksi' => 'required|date',
            'keterangan' => 'required|string|max:255',
        ], [
            'jumlah.min' => 'Minimal penarikan adalah Rp 10.000',
            'tanggal_transaksi.required' => 'Tanggal penarikan wajib diisi.',
        ]);

        // kalau rekening gak ketemu, balikin dengan error
        if (!$rekening) {
            return back()->with('error', 'Rekening tabungan tidak ditemukan.')->withInput();
        }

        // hitung maksimal penarikan = saldo - saldo mengendap
        // max(0, ...) biar gak minus
        $maksimalPenarikan = max(0, $rekening->saldo - $saldoMengendap);

        // kalau jumlah yang diminta > maksimal, tolak
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

        // mulai transaksi database
        DB::beginTransaction();

        try {
            // simpan pengajuan penarikan dengan status pending
            // nanti operator yang verifikasi
            DetailTabungan::create([
                'no_rek' => $rekening->no_rek,
                'id_petugas' => null, // belum ada petugas yang proses
                'id_jenis_transaksi' => 2, // 2 = penarikan
                'jumlah' => $request->jumlah,
                'tanggal_transaksi' => now()->timezone('Asia/Jakarta'),
                'keterangan' => $request->keterangan,
                'status' => 'pending',
            ]);

            // simpan permanen
            DB::commit();

            // balikin ke form dengan pesan sukses
            return redirect()->route('nasabah.penarikan.create')
                ->with(
                    'success',
                    'Pengajuan penarikan Rp ' .
                    number_format($request->jumlah, 0, ',', '.') .
                    ' berhasil dikirim! Menunggu verifikasi operator.'
                );

        } catch (\Exception $e) {
            // kalau error, batalkan semua perubahan
            DB::rollBack();

            // balikin ke form dengan pesan error
            return back()
                ->with('error', 'Gagal mengajukan: ' . $e->getMessage())
                ->withInput();
        }
    }
}