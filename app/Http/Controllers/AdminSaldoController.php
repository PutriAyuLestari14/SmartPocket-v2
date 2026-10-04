<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\Angsuran;
use App\Models\DetailTabungan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; // Tambahkan import DB

class AdminSaldoController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->periode ?? now()->format('Y-m');

        try {
            $startMonth = Carbon::createFromFormat('Y-m', $periode)->startOfMonth();
            $endMonth = Carbon::createFromFormat('Y-m', $periode)->endOfMonth();
        } catch (\Exception $e) {
            return back()->with('error', 'Format periode tidak valid.');
        }

        // 1. Hitung Total Jasa Masuk pada periode ini
        $totalJasa = Angsuran::whereBetween('tanggal_pembayaran', [$startMonth, $endMonth])
            ->sum('jumlah_jasa');

        // 2. Hitung Dana Bagi Hasil (20%)
        $persentaseBagiHasil = 20;
        $totalBagiHasil = $totalJasa * ($persentaseBagiHasil / 100);

        // 3. Cek Status Eksekusi (Sudah Diproses?)
        // Kita cek di tabel DetailTabungan apakah ada record dengan keterangan unik untuk periode ini
        $keteranganUnik = "Bagi Hasil Periode {$periode}";
        $sudahDiproses = DetailTabungan::where('keterangan', $keteranganUnik)->exists();

        // 4. Siapkan Simulasi Pembagian
        $simulasiPembagian = [];
        
        if (!$sudahDiproses && $totalBagiHasil > 0) {
            // Ambil semua nasabah yang punya rekening aktif (saldo > 0)
            $nasabahnya = Nasabah::with('rekening')
                ->whereHas('rekening', function($q) {
                    $q->where('saldo', '>', 0);
                })
                ->get();

            $totalSaldoPool = $nasabahnya->sum(fn($n) => $n->rekening->saldo ?? 0);

            if ($totalSaldoPool > 0) {
                foreach ($nasabahnya as $nasabah) {
                    $saldoRek = $nasabah->rekening->saldo ?? 0;
                    
                    // Rumus Proporsional: (Saldo Individu / Total Saldo Pool) * Dana Dibagi
                    $porsiPersen = $saldoRek / $totalSaldoPool;
                    $estimasiBagian = round($totalBagiHasil * $porsiPersen);

                    $simulasiPembagian[] = [
                        'id_nasabah' => $nasabah->id_nasabah,
                        'nama_nasabah' => $nasabah->nama,
                        'no_rek' => $nasabah->rekening->no_rek,
                        'saldo_sekarang' => $saldoRek,
                        'porsi_persen' => number_format($porsiPersen * 100, 2),
                        'estimasi_bagian' => $estimasiBagian,
                    ];
                }
            }
        }

        // Untuk kompatibilitas view lama jika masih memakai pagination list biasa
        // Tapi karena view baru kita pakai $simulasiPembagian, kita kirim keduanya
        $nasabahs = collect($simulasiPembagian); 

        return view('admin.saldo.index', compact(
            'periode',
            'totalJasa',
            'totalBagiHasil',
            'sudahDiproses',
            'simulasiPembagian', // Variabel utama untuk tabel simulasi
            'nasabahs'           // Alias jika view memanggil nama lain
        ));
    }

    /**
     * EKSEKUSI PROSES BAGI HASIL
     */
    public function proses(Request $request)
    {
        $request->validate([
            'periode' => 'required|string',
        ]);

        $periode = $request->input('periode');
        
        try {
            $startMonth = Carbon::createFromFormat('Y-m', $periode)->startOfMonth();
            $endMonth = Carbon::createFromFormat('Y-m', $periode)->endOfMonth();
        } catch (\Exception $e) {
            return back()->with('error', 'Format periode tidak valid.');
        }

        DB::beginTransaction();

        try {
            // 1. Hitung Ulang Data Real-time
            $totalJasa = Angsuran::whereBetween('tanggal_pembayaran', [$startMonth, $endMonth])
                ->sum('jumlah_jasa');

            if ($totalJasa <= 0) {
                throw new \Exception("Tidak ada jasa/penghasilan pada periode {$periode}.");
            }

            $danaDibagikan = $totalJasa * 0.20;

            // 2. Keamanan: Cek lagi apakah sudah diproses (Race Condition Prevention)
            $keteranganUnik = "Bagi Hasil Periode {$periode}";
            if (DetailTabungan::where('keterangan', $keteranganUnik)->exists()) {
                throw new \Exception("Data bagi hasil untuk periode {$periode} SUDAH DIPROSES.");
            }

            // 3. Ambil Data Nasabah & Total Saldo
            $nasabahnya = Nasabah::with('rekening')
                ->whereHas('rekening', function($q) {
                    $q->where('saldo', '>', 0);
                })
                ->get();

            $totalSaldoPool = $nasabahnya->sum(fn($n) => $n->rekening->saldo ?? 0);

            if ($totalSaldoPool <= 0) {
                throw new \Exception("Total saldo nasabah nol.");
            }

            $idPetugasLogin = auth()->id();
            $jumlahTerdampak = 0;

            // 4. Looping Update Saldo & Catat Transaksi
            foreach ($nasabahnya as $nasabah) {
                $rek = $nasabah->rekening;
                $saldoRek = $rek->saldo ?? 0;
                
                $porsi = $saldoRek / $totalSaldoPool;
                $bagianUang = round($danaDibagikan * $porsi);

                if ($bagianUang > 0) {
                    // A. UPDATE SALDO DI DATABASE
                    $newSaldo = $saldoRek + $bagianUang;
                    $rek->update(['saldo' => $newSaldo]);

                    // B. CATAT MUTASI DI DETAIL_TABUNGAN
                    // id_jenis_transaksi = 1 (Setoran/Bonus)
                    DetailTabungan::create([
                        'no_rek' => $rek->no_rek,
                        'id_petugas' => $idPetugasLogin,
                        'id_jenis_transaksi' => 1, 
                        'jumlah' => $bagianUang,
                        'status' => 'berhasil',
                        'tanggal_transaksi' => now(),
                        'keterangan' => $keteranganUnik, // Mark sebagai processed
                    ]);

                    $jumlahTerdampak++;
                }
            }

            DB::commit();

            return redirect()->route('admin.saldo.index', ['periode' => $periode])
                ->with('success', "Sukses! Bagi hasil periode {$periode} telah didistribusikan ke {$jumlahTerdampak} nasabah.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses bagi hasil: ' . $e->getMessage());
        }
    }

    // ... Method mutasiNasabah tetap sama seperti sebelumnya ...
    
    public function mutasiNasabah(Request $request, $idNasabah)
    {
         // ... (kode mutasiNasabah yang lama biarkan saja, tidak perlu diubah kecuali ada bug spesifik) ...
         // Saya asumsikan kode mutasiNasabah kamu sudah benar sesuai logic bisnis sebelumnya.
         
        $periode = $request->periode ?? now()->format('Y-m');
        $tanggalMulai = Carbon::createFromFormat('Y-m-d', $periode . '-01')->startOfDay();
        $tanggalSelesai = $tanggalMulai->copy()->endOfMonth()->endOfDay();

        $nasabah = Nasabah::with('rekening')->where('id_nasabah', $idNasabah)->firstOrFail();
        $rekening = $nasabah->rekening;

        if (!$rekening) {
            return response()->json(['success' => false, 'message' => 'Rekening nasabah tidak ditemukan.']);
        }

        $noRek = $rekening->no_rek;
        $transaksi = DetailTabungan::where('no_rek', $noRek)
            ->where('status', '!=', 'pending')
            ->whereDate('tanggal_transaksi', '<=', $tanggalSelesai)
            ->orderBy('tanggal_transaksi', 'asc')
            ->get();

        $saldoSekarang = (float) $rekening->saldo;
        $transaksiSetelahBulan = DetailTabungan::where('no_rek', $noRek)
            ->where('status', '!=', 'pending')
            ->whereDate('tanggal_transaksi', '>', $tanggalSelesai)
            ->get();

        $pengaruhSetelahBulan = 0;
        foreach ($transaksiSetelahBulan as $item) {
            if ($item->id_jenis_transaksi == 1) $pengaruhSetelahBulan += (float) $item->jumlah;
            elseif ($item->id_jenis_transaksi == 2) $pengaruhSetelahBulan -= (float) $item->jumlah;
        }

        $saldoAkhirBulan = $saldoSekarang - $pengaruhSetelahBulan;

        $transaksiDalamBulan = $transaksi->filter(function ($item) use ($tanggalMulai, $tanggalSelesai) {
            return Carbon::parse($item->tanggal_transaksi)->between($tanggalMulai, $tanggalSelesai);
        });

        $pengaruhDalamBulan = 0;
        foreach ($transaksiDalamBulan as $item) {
            if ($item->id_jenis_transaksi == 1) $pengaruhDalamBulan += (float) $item->jumlah;
            elseif ($item->id_jenis_transaksi == 2) $pengaruhDalamBulan -= (float) $item->jumlah;
        }

        $saldoAwalBulan = $saldoAkhirBulan - $pengaruhDalamBulan;
        $mutasi = [];
        $saldoBerjalan = $saldoAwalBulan;
        $totalSaldoHarian = 0;
        $totalDebet = 0;
        $totalKredit = 0;
        $jumlahHari = $tanggalMulai->daysInMonth;

        for ($i = 0; $i < $jumlahHari; $i++) {
            $tanggal = $tanggalMulai->copy()->addDays($i);
            $transaksiHariIni = $transaksi->filter(fn($item) => Carbon::parse($item->tanggal_transaksi)->isSameDay($tanggal));
            
            $debetHariIni = 0;
            $kreditHariIni = 0;

            foreach ($transaksiHariIni as $item) {
                $jumlah = (float) $item->jumlah;
                if ($item->id_jenis_transaksi == 1) $kreditHariIni += $jumlah;
                if ($item->id_jenis_transaksi == 2) $debetHariIni += $jumlah;
            }

            $saldoBerjalan = $saldoBerjalan + $kreditHariIni - $debetHariIni;
            $totalDebet += $debetHariIni;
            $totalKredit += $kreditHariIni;
            $totalSaldoHarian += $saldoBerjalan;

            $jenis = '-';
            if ($kreditHariIni > 0 && $debetHariIni > 0) $jenis = 'setoran & penarikan';
            elseif ($kreditHariIni > 0) $jenis = 'setoran';
            elseif ($debetHariIni > 0) $jenis = 'penarikan';

            $mutasi[] = [
                'no_rek' => $noRek,
                'nama' => $nasabah->nama,
                'tanggal' => $tanggal->format('Y-m-d'),
                'jenis' => $jenis,
                'debit' => $debetHariIni,
                'kredit' => $kreditHariIni,
                'saldo' => $saldoBerjalan,
            ];
        }

        $rataRataSaldo = $jumlahHari > 0 ? $totalSaldoHarian / $jumlahHari : 0;

        return response()->json([
            'success' => true,
            'saldo_awal_bulan' => round($saldoAwalBulan, 2),
            'saldo_akhir_bulan' => round($saldoAkhirBulan, 2),
            'rata_rata_saldo' => round($rataRataSaldo, 2),
            'total_debet' => round($totalDebet, 2),
            'total_kredit' => round($totalKredit, 2),
            'mutasi' => $mutasi,
        ]);
    }
}