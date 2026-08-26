<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NasabahPenarikanController extends Controller
{
    // Menampilkan halaman form
    public function create()
    {
        return view('nasabah.penarikan.create');
    }

    // Memproses data saat tombol diklik
    public function store(Request $request)
    {
        // 1. Validasi data
        $request->validate([
            'jumlah' => 'required|numeric|min:10000',
            'keterangan' => 'required|string|max:255',
        ], [
            'jumlah.min' => 'Minimal penarikan adalah Rp 10.000',
        ]);

        // 2. Nanti di sini logika simpan ke database
        // Contoh: Penarikan::create([...]);

        // 3. Kembalikan ke halaman dengan pesan sukses
        return redirect()->route('nasabah.penarikan.create')
                         ->with('success', 'Pengajuan penarikan sebesar Rp ' . number_format($request->jumlah, 0, ',', '.') . ' berhasil dikirim! Menunggu verifikasi operator.');
    }
}