<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nasabah;

class OperatorPeminjamanController extends Controller
{
    public function index()
    {
        return view('operator.peminjaman.index');
    }

    public function create()
    {

        $nasabahs = \App\Models\Nasabah::where('status', 'aktif')
            ->where('kategori', '!=', 'siswa') 
            ->orderBy('nama', 'asc')
            ->get();

        return view('operator.peminjaman.create', compact('nasabahs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_peminjam' => 'required|string|max:255',
            'nominal' => 'required|numeric|min:0',
            'tenor' => 'required|numeric|min:1',
            'bunga' => 'nullable|numeric|min:0|max:100',
            'tanggal_pinjam' => 'required|date',
            'tanggal_jatuh_tempo' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);
    }

    public function pembayaranIndex()
    {

    }

    public function storePembayaran()
    {

    }


}
