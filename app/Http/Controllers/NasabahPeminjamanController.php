<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use App\Models\Peminjaman; // Ganti dengan nama Model kamu

class NasabahPeminjamanController extends Controller
{
    public function create()
    {
        return view('nasabah.peminjaman.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:50000',
            'tanggal_pengembalian' => 'required|date|after:today',
            'metode_pembayaran' => 'required|in:tunai,potong_gaji,transfer',
            'keterangan' => 'nullable|string|max:255',
        ], [
            'jumlah.min' => 'Minimal jumlah pinjaman adalah Rp 50.000.',
            'tanggal_pengembalian.after' => 'Tanggal pengembalian harus di masa depan.',
        ]);

        // Nanti simpan ke database di sini, contoh:
        // Peminjaman::create([
        //     'user_id' => Auth::id(),
        //     'jumlah' => $request->jumlah,
        //     'tanggal_pengembalian' => $request->tanggal_pengembalian,
        //     'metode_pembayaran' => $request->metode_pembayaran,
        //     'keterangan' => $request->keterangan,
        //     'status' => 'pending',
        // ]);

        return redirect()->route('nasabah.peminjaman.create')
                         ->with('success', 'Pengajuan peminjaman sebesar Rp ' . number_format($request->jumlah, 0, ',', '.') . ' berhasil dikirim! Menunggu persetujuan operator.');
    }
}