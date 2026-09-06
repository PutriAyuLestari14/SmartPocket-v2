<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use App\Models\Peminjaman; // Ganti dengan nama Model kamu

class NasabahPeminjamanController extends Controller
{
    public function create()
    {
        //cek ini guru bukan sie 
        if (auth()->user()->nasabah->kategori !== 'guru') {
            return redirect()->route('nasabah.dashboard')
                ->with('error', 'Fitur peminjaman hanya tersedia untuk guru.');
        }

         return view('nasabah.peminjaman.create');
    }

    // proses data saat "AJUKAN" di klik nasabah
    public function store(Request $request)
    {
        if (auth()->user()->nasabah->kategori !== 'guru') {
            return redirect()->route('nasabah.dashboard')
                ->with('error', 'Fitur peminjaman hanya tersedia untuk guru.');
        }

        $request->validate([
            'jumlah' => 'required|numeric|min:50000',
            'tanggal_pengembalian' => 'required|date|after:today',
            'metode_pembayaran' => 'required|in:tunai,potong_gaji,transfer',
            'keterangan' => 'nullable|string|max:255',
        ], [
            'jumlah.min' => 'Minimal jumlah pinjaman adalah Rp 50.000.',
            'tanggal_pengembalian.after' => 'Tanggal pengembalian harus di masa depan.',
        ]);

        return redirect()->route('nasabah.peminjaman.create')
            ->with('success', 'Pengajuan peminjaman sebesar Rp ' . number_format($request->jumlah, 0, ',', '.') . ' berhasil dikirim! Menunggu persetujuan operator.');
    }
}