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
        // cek dulu, ini guru atau bukan
        // karena fitur pinjaman cuma buat guru
        if (auth()->user()->nasabah->kategori !== 'guru') {
            return redirect()->route('nasabah.dashboard')
                ->with('error', 'Fitur peminjaman hanya tersedia untuk guru.');
        }

        // kalau guru, tampilkan form
        return view('nasabah.peminjaman.create');
    }

    // proses simpan saat tombol "ajukan" diklik
    public function store(Request $request)
    {
        // ambil user & nasabah yang login
        $user = auth()->user();
        $nasabah = $user->nasabah;
        
        // validasi input dari form
        // jumlah min 50rb, tenor 1-24 bulan, tanggal jatuh tempo harus setelah tanggal pinjam
        $validated = $request->validate([
            'jumlah' => 'required|numeric|min:50000',
            'tenor' => 'required|integer|min:1|max:24',
            'tanggal_pinjam' => 'required|date',
            'tanggal_jatuh_tempo' => 'required|date|after:tanggal_pinjam',
            'keterangan' => 'nullable|string|max:500',
        ]);

        // mulai transaksi database
        DB::beginTransaction();
        
        try {
            // ambil nilai dari input yang udah divalidasi
            $jumlahPinjaman = $validated['jumlah'];
            $tenor = $validated['tenor'];
            
            // hitung jasa (bunga) per bulan = 1% dari jumlah pinjaman
            $jasaPerBulan = $jumlahPinjaman * 0.01;

            // total jasa = jasa per bulan x tenor
            $totaljasa = $jasaPerBulan * $tenor;

            // simpan pengajuan ke tabel peminjaman
            Peminjaman::create([
                'id_nasabah' => $nasabah->id_nasabah,
                'id_petugas' => null, // belum ada petugas yang proses
                'tanggal_ajuan' => $validated['tanggal_pinjam'],
                'tanggal_jatuh_tempo' => $validated['tanggal_jatuh_tempo'],
                'jumlah_pinjaman' => $jumlahPinjaman,
                'tenor' => $tenor,
                'sisa_pinjaman' => $jumlahPinjaman, // awalnya sisa = jumlah pinjaman

                // kolom jasa (bunga) yang disimpan
                'total_jasa' => $totaljasa,
                'jasa_per_bulan' => $jasaPerBulan,
                'sisa_jasa' => $totaljasa,

                'keterangan' => $validated['keterangan'],
                'status_verifikasi' => 'pending', // nunggu verifikasi operator
            ]);

            // simpan permanen
            DB::commit();
            
            // balikin ke form dengan pesan sukses
            return redirect()->route('nasabah.peminjaman.create')
                ->with('success', 'Pengajuan pinjaman berhasil diajukan! Menunggu verifikasi operator.');

        } catch (\Exception $e) {
            // kalau error, batalkan semua perubahan
            DB::rollBack();

            // balikin ke form dengan pesan error
            return back()->withInput()->with('error', 'Gagal mengajukan pinjaman: ' . $e->getMessage());
        }
    }
}