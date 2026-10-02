<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\Peminjaman;
use App\Models\Angsuran;
use App\Models\Petugas;
use App\Http\Controllers\NotifikasiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OperatorPembayaranController extends Controller
{
    // tampilkan form input pembayaran cicilan
    public function create(Request $request)
    {
        // default semua null/kosong
        $nasabah = null;
        $peminjamanAktif = collect();
        $pinjamanTerpilih = null;

        // kalau ada id_pinjaman di url (dari tombol bayar di tabel)
        if ($request->has('id_pinjaman') && $request->id_pinjaman) {
            // cari pinjaman yang dimaksud
            $pinjamanTerpilih = Peminjaman::with('nasabah')->find($request->id_pinjaman);
            if ($pinjamanTerpilih) {
                // kalau ketemu, ambil nasabahnya ceelah
                $nasabah = $pinjamanTerpilih->nasabah;
                // bikin collection isinya cuma 1 pinjaman ini
                $peminjamanAktif = collect([$pinjamanTerpilih]);
            }
        } 
        // kalau ada pencarian nasabah
        elseif ($request->has('cari') && !empty($request->cari)) {
            $keyword = $request->cari;
        
            // cari nasabah berdasarkan nama atau username
            $nasabah = Nasabah::where('nama', 'LIKE', "%{$keyword}%")
                            ->orWhere('username', 'LIKE', "%{$keyword}%")
                            ->first();

            // kalau ketemu, ambil pinjaman aktifnya
            if ($nasabah) {
                $peminjamanAktif = Peminjaman::where('id_nasabah', $nasabah->id_nasabah)
                    ->where('sisa_pinjaman', '>', 0)
                    ->whereIn('status_verifikasi', ['disetujui', 'aktif'])
                    ->orderBy('tanggal_ajuan', 'desc')
                    ->get();
            }
        }

        // tambah data tambahan buat tiap pinjaman aktif
        $peminjamanAktif->each(function ($pinjaman) {
            // hitung cicilan ke berapa selanjutnya = sudah bayar + 1
            $sudahBayar = Angsuran::where('id_pinjaman', $pinjaman->id_pinjaman)
                                  ->where('jumlah_pokok', '>', 0)
                                  ->count();
            $pinjaman->next_cicilan_ke = $sudahBayar + 1;

            // ambil daftar bulan yang udah dibayar jasa (format Y-m)
            // biar bisa cek apa bulan ini udah bayar jasa
            $pinjaman->jasa_bulan = Angsuran::where('id_pinjaman', $pinjaman->id_pinjaman)
                ->where('jumlah_jasa', '>', 0)
                ->get()
                ->map(function ($angsuran) {
                    return \Carbon\Carbon::parse($angsuran->tanggal_pembayaran)->format('Y-m');
                })
                ->unique()
                ->values()
                ->toArray();
        });

        // kirim ke view
        return view('operator.pembayaran.create', compact('nasabah', 'peminjamanAktif', 'pinjamanTerpilih'));
    }

    // proses simpan pembayaran cicilan
    public function store(Request $request)
    {
        // validasi input
        $validated = $request->validate([
            'id_pinjaman' => 'required|exists:peminjaman,id_pinjaman',
            'cicilan_ke' => 'required|integer|min:1',
            'tanggal_pembayaran' => 'required|date',
            'jumlah' => 'required|numeric|min:1',
            'jenis_pembayaran' => 'required|in:pokok,jasa,keduanya',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // mulai transaksi
        DB::beginTransaction();

        try {
            // ambil petugas yang login
            $user = Auth::user();
            $petugas = Petugas::where('username', $user->username)->first();

            // kalau gak ada petugas, gagal
            if (!$petugas) {
                throw new \Exception('Data petugas tidak ditemukan! Silakan hubungi administrator.');
            }

            // cari pinjaman yang mau dibayar
            $peminjaman = Peminjaman::findOrFail($validated['id_pinjaman']);

            // siapin variabel buat pokok & jasa
            $jumlahBayar = (int) $validated['jumlah'];
            $jumlahPokok = 0;
            $jumlahJasa = 0;

            // hitung jasa per bulan
            $jasaPerBulan = (int) $peminjaman->jasa_per_bulan;

            // hitung total jasa yang udah dibayar
            $jasaSudahDibayar = (int) Angsuran::where('id_pinjaman', $peminjaman->id_pinjaman)->sum('jumlah_jasa');

            // ambil tanggal bayar
            $tanggalBayar = \Carbon\Carbon::parse($validated['tanggal_pembayaran']);

            // cek apakah bulan & tahun ini udah bayar jasa
            $jasaBulanIniSudahDibayar = Angsuran::where('id_pinjaman', $peminjaman->id_pinjaman)
                ->whereYear('tanggal_pembayaran', $tanggalBayar->year)
                ->whereMonth('tanggal_pembayaran', $tanggalBayar->month)
                ->where('jumlah_jasa', '>', 0)
                ->exists();

            // kalau bulan ini belum bayar jasa, berarti kena 1%
            // kalau udah bayar, berarti 0 (gak kena lagi)
            $jasaBelumDibayar = $jasaBulanIniSudahDibayar ? 0 : $jasaPerBulan;
            
            // bagi pembayaran sesuai jenisnya
            if ($validated['jenis_pembayaran'] === 'pokok') {
                // kalau bayar lebih dari sisa, error
                if ($jumlahBayar > (int) $peminjaman->sisa_pinjaman) {
                    throw new \Exception('Jumlah pembayaran pokok melebihi sisa pinjaman.');
                }
                // semua ke pokok, jasa 0
                $jumlahPokok = $jumlahBayar;
                $jumlahJasa = 0;

            } elseif ($validated['jenis_pembayaran'] === 'jasa') {
                // kalau jasa bulan ini udah dibayar, error
                if ($jasaBelumDibayar <= 0) {
                    throw new \Exception('Jasa bulan ini sudah dibayar.');
                }
                // kalau bayar lebih dari jasa bulan ini, error
                if ($jumlahBayar > $jasaBelumDibayar) {
                    throw new \Exception('Jumlah pembayaran jasa melebihi jasa bulan ini.');
                }
                // semua ke jasa, pokok 0
                $jumlahPokok = 0;
                $jumlahJasa = $jumlahBayar;

            } elseif ($validated['jenis_pembayaran'] === 'keduanya') {
                // kalau jasa belum dibayar
                if ($jasaBelumDibayar > 0) {
                    // bayaran harus cukup buat jasa dulu
                    if ($jumlahBayar < $jasaBelumDibayar) {
                        throw new \Exception('Pembayaran belum cukup untuk membayar jasa bulan ini.');
                    }
                    // jasa dibayar dulu, sisanya ke pokok
                    $jumlahJasa = $jasaBelumDibayar;
                    $jumlahPokok = min($jumlahBayar - $jumlahJasa, (int) $peminjaman->sisa_pinjaman);
                } else {
                    // kalau jasa udah dibayar, semua ke pokok
                    $jumlahJasa = 0;
                    $jumlahPokok = min($jumlahBayar, (int) $peminjaman->sisa_pinjaman);
                }
            }

            // simpan angsuran
            Angsuran::create([
                'id_pinjaman' => $peminjaman->id_pinjaman,
                'id_petugas' => $petugas->id_petugas,
                'tanggal_pembayaran' => $validated['tanggal_pembayaran'],
                'cicilan_ke' => $validated['cicilan_ke'],
                'jumlah' => $jumlahBayar,
                'jumlah_pokok' => $jumlahPokok,
                'jumlah_jasa' => $jumlahJasa,
                'jenis_pembayaran' => $validated['jenis_pembayaran'],
                'keterangan' => $validated['keterangan'],
            ]);

            // update sisa pokok
            $peminjaman->sisa_pinjaman = max(0, (int) $peminjaman->sisa_pinjaman - $jumlahPokok);

            // update sisa jasa = total jasa awal - jasa yang udah dibayar
            $totalJasaAwal = $peminjaman->total_jasa; 
            $totalJasaSudahDibayar = $jasaSudahDibayar + $jumlahJasa;
            $peminjaman->sisa_jasa = max(0, $totalJasaAwal - $totalJasaSudahDibayar);

            // kalau sisa pokok & jasa udah 0, tandai lunas
            if ($peminjaman->sisa_pinjaman <= 0 && $peminjaman->sisa_jasa <= 0) {
                $peminjaman->status_verifikasi = 'lunas';
            }

            // simpan perubahan
            $peminjaman->save();

            // kirim notifikasi ke nasabah
            NotifikasiController::kirim(
                $peminjaman->id_nasabah,
                'Pembayaran Cicilan Berhasil',
                'Pembayaran Rp ' . number_format($jumlahBayar, 0, ',', '.') .
                ' telah berhasil dicatat. Pokok: Rp ' . number_format($jumlahPokok, 0, ',', '.') .
                ', Jasa: Rp ' . number_format($jumlahJasa, 0, ',', '.') .
                '. Sisa pinjaman: Rp ' . number_format($peminjaman->sisa_pinjaman, 0, ',', '.') . '.',
                'pembayaran'
            );

            // simpan permanen
            DB::commit();

            // balikin ke form dengan pesan sukses
            return redirect()
                ->route('operator.pembayaran.create')
                ->with('success', 'Pembayaran Rp ' . number_format($jumlahBayar, 0, ',', '.') . ' berhasil diproses. Pokok: Rp ' . number_format($jumlahPokok, 0, ',', '.') . ', Jasa: Rp ' . number_format($jumlahJasa, 0, ',', '.') . '.');

        } catch (\Exception $e) {
            // kalau error, batalkan
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }
}