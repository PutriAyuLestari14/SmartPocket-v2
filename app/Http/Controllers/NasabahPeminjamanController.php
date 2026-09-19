<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Peminjaman;
use App\Models\Nasabah;
use Illuminate\Support\Facades\DB; 

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
        $user = auth()->user();
        $nasabah = $user->nasabah;
        
        // Validasi (SESUAIKAN DENGAN FORM BARU)
        $validated = $request->validate([
            'jumlah' => 'required|numeric|min:50000',
            'tenor' => 'required|integer|min:1|max:24',
            'tanggal_pinjam' => 'required|date',
            'tanggal_jatuh_tempo' => 'required|date|after:tanggal_pinjam',
            'keterangan' => 'nullable|string|max:500',
            // HAPUS: 'metode_pembayaran' dan 'tanggal_pengembalian'
        ]);

        \DB::beginTransaction();
        
        try {
            // Simpan ke tabel peminjaman
            Peminjaman::create([
                'id_nasabah' => $nasabah->id_nasabah,
                'id_petugas' => null,
                'tanggal_ajuan' => $validated['tanggal_pinjam'],
                'tanggal_jatuh_tempo' => $validated['tanggal_jatuh_tempo'],
                'jumlah_pinjaman' => $validated['jumlah'],
                'tenor' => $validated['tenor'],
                'sisa_pinjaman' => $validated['jumlah'],
                'keterangan' => $validated['keterangan'],
                'status_verifikasi' => 'pending',
            ]);

            DB::commit();
            return redirect()->route('nasabah.peminjaman.create')
                ->with('success', 'Pengajuan pinjaman berhasil diajukan! Menunggu verifikasi operator.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal mengajukan pinjaman: ' . $e->getMessage());
        }
    }
}