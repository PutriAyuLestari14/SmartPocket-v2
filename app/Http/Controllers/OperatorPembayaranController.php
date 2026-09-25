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

                    $peminjamanAktif->each(function ($pinjaman) {
                        $pinjaman->jasa_bulan = Angsuran::where('id_pinjaman', $pinjaman->id_pinjaman)
                            ->where('jumlah_jasa', '>', 0)
                            ->get()
                            ->map(function ($angsuran) {
                                return \Carbon\Carbon::parse($angsuran->tanggal_pembayaran)
                                    ->format('Y-m');
                            })
                            ->unique()
                            ->values()
                            ->toArray();
                    });
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
        $validated = $request->validate([
            'id_pinjaman' => 'required|exists:peminjaman,id_pinjaman',
            'cicilan_ke' => 'required|integer|min:1',
            'tanggal_pembayaran' => 'required|date',
            'jumlah' => 'required|numeric|min:1',
            'jenis_pembayaran' => 'required|in:pokok,bunga,keduanya',
            'keterangan' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $user = Auth::user();
            $petugas = Petugas::where('username', $user->username)->first();

            if (!$petugas) {
                throw new \Exception(
                    'Data petugas tidak ditemukan! Silakan hubungi administrator.'
                );
            }

            $peminjaman = Peminjaman::findOrFail($validated['id_pinjaman']);

            $jumlahBayar = (int) $validated['jumlah'];
            $jumlahPokok = 0;
            $jumlahJasa = 0;

            /*
            |--------------------------------------------------------------------------
            | HITUNG JASA
            |--------------------------------------------------------------------------
            */

            $jasaPerBulan = (int) $peminjaman->bunga_per_bulan;

            // Total jasa yang sudah dibayar
            $jasaSudahDibayar = (int) Angsuran::where(
                'id_pinjaman',
                $peminjaman->id_pinjaman
            )->sum('jumlah_jasa');

            // Tentukan bulan pembayaran sekarang
            $tanggalBayar = \Carbon\Carbon::parse($validated['tanggal_pembayaran']);

            // Ambil semua pembayaran sebelumnya
            $pembayaranSebelumnya = Angsuran::where(
                'id_pinjaman',
                $peminjaman->id_pinjaman
            )->get();

            // Cek apakah bulan ini sudah pernah bayar jasa
            $jasaBulanIniSudahDibayar = $pembayaranSebelumnya->contains(function ($angsuran) use ($tanggalBayar) {
                $tanggalSebelumnya = \Carbon\Carbon::parse($angsuran->tanggal_pembayaran);

                return $tanggalSebelumnya->year === $tanggalBayar->year
                    && $tanggalSebelumnya->month === $tanggalBayar->month
                    && $angsuran->jumlah_jasa > 0;
            });

            // Kalau bulan ini belum bayar jasa → kena 1%
            // Kalau bulan ini sudah bayar jasa → tidak kena lagi
            $jasaBelumDibayar = $jasaBulanIniSudahDibayar
                ? 0
                : $jasaPerBulan;
                
            $jasaSeharusnya = $jasaPerBulan;
            /*
            |--------------------------------------------------------------------------
            | PEMBAGIAN PEMBAYARAN
            |--------------------------------------------------------------------------
            */

            if ($validated['jenis_pembayaran'] === 'pokok') {

                if ($jumlahBayar > (int) $peminjaman->sisa_pinjaman) {
                    throw new \Exception(
                        'Jumlah pembayaran pokok melebihi sisa pinjaman.'
                    );
                }

                $jumlahPokok = $jumlahBayar;
                $jumlahJasa = 0;

            } elseif ($validated['jenis_pembayaran'] === 'bunga') {

                if ($jasaBelumDibayar <= 0) {
                    throw new \Exception(
                        'Jasa bulan ini sudah dibayar.'
                    );
                }

                if ($jumlahBayar > $jasaBelumDibayar) {
                    throw new \Exception(
                        'Jumlah pembayaran jasa melebihi jasa bulan ini.'
                    );
                }

                $jumlahPokok = 0;
                $jumlahJasa = $jumlahBayar;

            } elseif ($validated['jenis_pembayaran'] === 'keduanya') {

                if ($jasaBelumDibayar > 0) {

                    if ($jumlahBayar < $jasaBelumDibayar) {
                        throw new \Exception(
                            'Pembayaran belum cukup untuk membayar jasa bulan ini.'
                        );
                    }

                    $jumlahJasa = $jasaBelumDibayar;

                    $jumlahPokok = min(
                        $jumlahBayar - $jumlahJasa,
                        (int) $peminjaman->sisa_pinjaman
                    );

                } else {

                    $jumlahJasa = 0;

                    $jumlahPokok = min(
                        $jumlahBayar,
                        (int) $peminjaman->sisa_pinjaman
                    );
                }
            }            /*
            |--------------------------------------------------------------------------
            | SIMPAN PEMBAYARAN
            |--------------------------------------------------------------------------
            */

            Angsuran::create([
                'id_pinjaman' => $peminjaman->id_pinjaman,
                'id_petugas' => $petugas->id_petugas,
                'tanggal_pembayaran' => $validated['tanggal_pembayaran'],
                'jumlah' => $jumlahBayar,
                'jumlah_pokok' => $jumlahPokok,
                'jumlah_jasa' => $jumlahJasa,
                'jenis_pembayaran' => $validated['jenis_pembayaran'],
            ]);

            /*
            |--------------------------------------------------------------------------
            | UPDATE SISA POKOK
            |--------------------------------------------------------------------------
            */

            $peminjaman->sisa_pinjaman = max(
                0,
                (int) $peminjaman->sisa_pinjaman - $jumlahPokok
            );

            /*
            |--------------------------------------------------------------------------
            | UPDATE SISA JASA
            |--------------------------------------------------------------------------
            */

            $totalJasaSudahDibayar = $jasaSudahDibayar + $jumlahJasa;

            $peminjaman->sisa_bunga = max(
                0,
                $jasaSeharusnya - $totalJasaSudahDibayar
            );

            /*
            |--------------------------------------------------------------------------
            | CEK LUNAS
            |--------------------------------------------------------------------------
            */

            if (
                $peminjaman->sisa_pinjaman <= 0 &&
                $peminjaman->sisa_bunga <= 0
            ) {
                $peminjaman->status_verifikasi = 'lunas';
            }

            $peminjaman->save();

            DB::commit();

            return redirect()
                ->route('operator.pembayaran.create')
                ->with(
                    'success',
                    'Pembayaran Rp ' .
                    number_format($jumlahBayar, 0, ',', '.') .
                    ' berhasil diproses. Pokok: Rp ' .
                    number_format($jumlahPokok, 0, ',', '.') .
                    ', Jasa: Rp ' .
                    number_format($jumlahJasa, 0, ',', '.') .
                    '.'
                );

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Gagal memproses pembayaran: ' .
                    $e->getMessage()
                );
        }
    }
}