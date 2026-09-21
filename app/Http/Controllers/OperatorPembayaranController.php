<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\Peminjaman;
use App\Models\Angsuran;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OperatorPembayaranController extends Controller
{
    /**
     * Menampilkan form input pembayaran dengan data real
     */
    public function create(Request $request)
    {
        $nasabah = null;
        $peminjamanAktif = collect();

        // Jika ada parameter pencarian (berdasarkan nama atau username/NIP)
        if ($request->has('cari') && !empty($request->cari)) {
            $keyword = $request->cari;
            
            $nasabah = Nasabah::where('nama', 'LIKE', "%{$keyword}%")
                              ->orWhere('username', 'LIKE', "%{$keyword}%")
                              ->first();

            if ($nasabah) {
                // Ambil pinjaman yang masih memiliki sisa dan statusnya disetujui/aktif
                $peminjamanAktif = Peminjaman::where('id_nasabah', $nasabah->id_nasabah)
                                             ->where('sisa_pinjaman', '>', 0)
                                             ->whereIn('status_verifikasi', ['disetujui', 'aktif'])
                                             ->orderBy('tanggal_ajuan', 'desc')
                                             ->get();
            }
        }

        return view('operator.pembayaran.create', compact('nasabah', 'peminjamanAktif'));
    }

    /**
     * Memproses penyimpanan pembayaran cicilan ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_pinjaman'       => 'required|exists:peminjaman,id_pinjaman',
            'cicilan_ke'        => 'required|integer|min:1',
            'tanggal_pembayaran'=> 'required|date',
            'jumlah'            => 'required|numeric|min:1',
            'keterangan'        => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // 1. Cari data petugas yang sedang login
            $user = Auth::user();
            $petugas = Petugas::where('username', $user->username)->first();

            if (!$petugas) {
                return back()->with('error', 'Data petugas tidak ditemukan! Silakan hubungi administrator.');
            }

            // 2. Simpan data ke tabel angsuran dengan id_petugas yang benar
            Angsuran::create([
                'id_pinjaman'        => $validated['id_pinjaman'],
                'id_petugas'         => $petugas->id_petugas,
                'tanggal_pembayaran' => $validated['tanggal_pembayaran'],
                'jumlah'             => $validated['jumlah'],
            ]);

            // 3. Update tabel peminjaman: kurangi sisa pinjaman
            $peminjaman = Peminjaman::findOrFail($validated['id_pinjaman']);
            $peminjaman->decrement('sisa_pinjaman', $validated['jumlah']);

            // 4. Jika sisa pinjaman habis, ubah status menjadi lunas
            if ($peminjaman->sisa_pinjaman <= 0) {
                $peminjaman->update(['status_verifikasi' => 'lunas']);
            }

            DB::commit();
            
            return redirect()->route('operator.pembayaran.create')
                             ->with('success', 'Pembayaran cicilan sebesar Rp ' . number_format($validated['jumlah'], 0, ',', '.') . ' berhasil diproses!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage())->withInput();
        }
    }
}