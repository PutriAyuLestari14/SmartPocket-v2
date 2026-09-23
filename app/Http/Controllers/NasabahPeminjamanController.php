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
        // Cek apakah ini guru atau bukan
        if (auth()->user()->nasabah->kategori !== 'guru') {
            return redirect()->route('nasabah.dashboard')
                ->with('error', 'Fitur peminjaman hanya tersedia untuk guru.');
        }

        return view('nasabah.peminjaman.create');
    }

    // Proses data saat "AJUKAN" diklik nasabah
    public function store(Request $request)
    {
        $user = auth()->user();
        $nasabah = $user->nasabah;
        
        // Validasi
        $validated = $request->validate([
            'jumlah' => 'required|numeric|min:50000',
            'tenor' => 'required|integer|min:1|max:24',
            'tanggal_pinjam' => 'required|date',
            'tanggal_jatuh_tempo' => 'required|date|after:tanggal_pinjam',
            'keterangan' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        
        try {
            // 1. HITUNG BUNGA DULU SEBELUM DISIMPAN
            $jumlahPinjaman = $validated['jumlah'];
            $tenor = $validated['tenor'];
            
            $bungaPerBulan = $jumlahPinjaman * 0.01; // 1% per bulan
            $totalBunga = $bungaPerBulan * $tenor;   // Total bunga selama tenor

            // 2. Simpan ke tabel peminjaman
            Peminjaman::create([
                'id_nasabah' => $nasabah->id_nasabah,
                'id_petugas' => null,
                'tanggal_ajuan' => $validated['tanggal_pinjam'],
                'tanggal_jatuh_tempo' => $validated['tanggal_jatuh_tempo'],
                'jumlah_pinjaman' => $jumlahPinjaman,
                'tenor' => $tenor,
                'sisa_pinjaman' => $jumlahPinjaman,
                
                // TAMBAHAN KOLOM BUNGA (BIAR TERSIMPAN DI DATABASE)
                'total_bunga' => $totalBunga,
                'bunga_per_bulan' => $bungaPerBulan,
                'sisa_bunga' => $totalBunga, 
                
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