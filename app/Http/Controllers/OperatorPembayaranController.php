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
        $pinjamanTerpilih = null;

        // 1. Jika ada pencarian nasabah
        if ($request->has('cari') && !empty($request->cari)) {
            $keyword = $request->cari;
        
            $nasabah = Nasabah::where('nama', 'LIKE', "%{$keyword}%")
                            ->orWhere('username', 'LIKE', "%{$keyword}%")
                            ->first();

            if ($nasabah) {
                $peminjamanAktif = Peminjaman::where('id_nasabah', $nasabah->id_nasabah)
                                             ->where('sisa_pinjaman', '>', 0)
                                             ->whereIn('status_verifikasi', ['disetujui', 'aktif'])
                                             ->orderBy('tanggal_ajuan', 'desc')
                                             ->get();
            }
        }

        // 2. Jika ada ID pinjaman yang dipilih (misal dari dropdown atau redirect)
        if ($request->has('id_pinjaman') && $request->id_pinjaman) {
            $pinjamanTerpilih = Peminjaman::find($request->id_pinjaman);
        }

        return view('operator.pembayaran.create', compact('nasabah', 'peminjamanAktif', 'pinjamanTerpilih'));
    }

    /**
     * Memproses penyimpanan pembayaran cicilan ke database (Dengan Logika Bunga 1% Flat)
     */
    public function store(Request $request)
    {
        // 1. Validasi Input (TAMBAHAN: jenis_pembayaran)
        $validated = $request->validate([
            'id_pinjaman'       => 'required|exists:peminjaman,id_pinjaman',
            'cicilan_ke'        => 'required|integer|min:1',
            'tanggal_pembayaran'=> 'required|date',
            'jumlah'            => 'required|numeric|min:1',
            'jenis_pembayaran'  => 'required|in:pokok,bunga,keduanya', // <-- VALIDASI BARU
            'keterangan'        => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // 2. Cari data petugas yang sedang login
            $user = Auth::user();
            $petugas = Petugas::where('username', $user->username)->first();

            if (!$petugas) {
                return back()->with('error', 'Data petugas tidak ditemukan! Silakan hubungi administrator.');
            }

            // 3. Simpan data ke tabel angsuran (TAMBAHAN: jenis_pembayaran)
            Angsuran::create([
                'id_pinjaman'        => $validated['id_pinjaman'],
                'id_petugas'         => $petugas->id_petugas,
                'tanggal_pembayaran' => $validated['tanggal_pembayaran'],
                'jumlah'             => $validated['jumlah'],
                'jenis_pembayaran'   => $validated['jenis_pembayaran'], // <-- SIMPAN JENIS
            ]);

            // 4. Update tabel peminjaman berdasarkan JENIS pembayaran
            $peminjaman = Peminjaman::findOrFail($validated['id_pinjaman']);
            $jumlahBayar = $validated['jumlah'];
            $jenis = $validated['jenis_pembayaran'];

            if ($jenis === 'bunga') {
                // Kurangi sisa bunga saja
                $peminjaman->sisa_bunga -= $jumlahBayar;
                if ($peminjaman->sisa_bunga < 0) {
                    $peminjaman->sisa_bunga = 0;
                }
            } 
            elseif ($jenis === 'pokok') {
                // Kurangi sisa pokok saja
                $peminjaman->sisa_pinjaman -= $jumlahBayar;
                if ($peminjaman->sisa_pinjaman < 0) {
                    $peminjaman->sisa_pinjaman = 0;
                }
            } 
            elseif ($jenis === 'keduanya') {
                // Bayar bunga dulu sampai habis, sisanya baru potong pokok
                if ($jumlahBayar <= $peminjaman->sisa_bunga) {
                    $peminjaman->sisa_bunga -= $jumlahBayar;
                } else {
                    $sisaUangUntukPokok = $jumlahBayar - $peminjaman->sisa_bunga;
                    $peminjaman->sisa_bunga = 0;
                    $peminjaman->sisa_pinjaman -= $sisaUangUntukPokok;
                }
                
                if ($peminjaman->sisa_pinjaman < 0) {
                    $peminjaman->sisa_pinjaman = 0;
                }
            }

            // Simpan perubahan sisa pinjaman & bunga
            $peminjaman->save();

            // 5. Cek apakah sudah LUNAS total (Pokok DAN Bunga habis)
            if ($peminjaman->sisa_pinjaman <= 0 && $peminjaman->sisa_bunga <= 0) {
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