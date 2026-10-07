<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Angsuran;       
use App\Models\RekeningTabungan; 
use App\Models\DetailTabungan;   
use App\Models\Nasabah;          
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminUpdateSaldoController extends Controller
{
    /**
     * Halaman Preview Bagi Hasil
     */
        public function index(Request $request)
    {
        // Gunakan parameter 'periode' sesuai Input Name di View
        $periodeStr = $request->get('periode', now()->format('Y-m'));
        
        try {
            $startMonth = Carbon::createFromFormat('Y-m', $periodeStr)->startOfMonth();
            $endMonth = Carbon::createFromFormat('Y-m', $periodeStr)->endOfMonth();
        } catch (\Exception $e) {
            return back()->with('error', 'Format bulan tidak valid.');
        }

        // 1. Cek Status Eksekusi DULUAN
        // Kita cek apakah ada transaksi bagi hasil untuk periode ini di masa lalu
        $keteranganUnik = "Bagi Hasil Periode {$periodeStr}";
        $sudahDiproses = DetailTabungan::where('keterangan', $keteranganUnik)->exists();

        // 2. Hitung Total Jasa Masuk
        $totalJasaMasuk = Angsuran::whereBetween('tanggal_pembayaran', [$startMonth, $endMonth])
            ->sum('jumlah_jasa');

        // 3. Tentukan Porsi Bagi Hasil (20%)
        $persentaseBagiHasil = 20; 
        
        // ⚠️ PERBAIKAN UTAMA DI SINI ⚠️
        // Jika sudah diproses, paksa dana yang bisa dibagi jadi 0.
        // Ini membuat tampilan card hijau berubah menjadi Rp 0 setelah sukses.
        if ($sudahDiproses) {
            $danaDibagikan = 0;
        } else {
            $danaDibagikan = $totalJasaMasuk * ($persentaseBagiHasil / 100);
        }

        // 4. Ambil Data NASABAH agar relasi nama & saldo utuh
        // Hanya ambil jika BELUM diproses, karena jika sudah, simulasi tidak diperlukan lagi
        $simulasiPembagian = [];
        $nasabahs = collect([]); // Default empty collection
        
        if (!$sudahDiproses && $danaDibagikan > 0) {
            $nasabahs = Nasabah::whereHas('rekening', function($q) {
                    $q->where('saldo', '>', 0);
                })
                ->with('rekening')
                ->get();

            $totalSaldoNasabah = $nasabahs->sum(fn($n) => $n->rekening->saldo);

            if ($totalSaldoNasabah > 0) {
                foreach ($nasabahs as $nasabah) {
                    $saldoRek = $nasabah->rekening->saldo;
                    $porsiPersen = $saldoRek / $totalSaldoNasabah;
                    $nominalDapat = round($danaDibagikan * $porsiPersen); 
                    
                    $simulasiPembagian[] = [
                        'id_nasabah' => $nasabah->id_nasabah,
                        'no_rek' => $nasabah->rekening->no_rek,
                        'nama_nasabah' => $nasabah->nama ?? 'Tanpa Nama', 
                        'saldo_sekarang' => $saldoRek,
                        'porsi_persen' => number_format($porsiPersen * 100, 2),
                        'estimasi_bagian' => $nominalDapat,
                    ];
                }
            }
        }

        return view('admin.saldo.index', compact(
            'periodeStr',
            'totalJasaMasuk',
            'danaDibagikan',       // Sekarang akan bernilai 0 jika $sudahDiproses = true
            'persentaseBagiHasil',
            'sudahDiproses',       // Flag ini dipakai View untuk menyembunyikan tombol proses
            'simulasiPembagian',
            'nasabahs'
        ));
    }

    /**
     * Eksekusi Proses Bagi Hasil
     */
        public function store(Request $request)
    {
        // Validasi input name 'periode' sesuai form GET/POST sebelumnya
        $request->validate([
            'periode' => 'required|string',
        ]);

        $periodeStr = $request->input('periode');
        
        try {
            $startMonth = Carbon::createFromFormat('Y-m', $periodeStr)->startOfMonth();
            $endMonth = Carbon::createFromFormat('Y-m', $periodeStr)->endOfMonth();
        } catch (\Exception $e) {
            return back()->with('error', 'Format periode tidak valid.');
        }

        DB::beginTransaction();

        try {
            // ---------------------------------------------------------
            // 1. DETEKSI ID PETUGAS YANG BENAR (SESUAI FOREIGN KEY)
            // ---------------------------------------------------------
            
            // Asumsi: Model User memiliki relasi ke model Petugas (One-to-One)
            // Jika struktur databasemu berbeda, sesuaikan query di bawah ini.
            
            $user = auth()->user();
            
            if (!$user) {
                throw new \Exception("Sesi berakhir.");
            }

            // Coba ambil relasi petugas langsung dari user object
            // Jika model User punya method: public function petugas() { return $this->hasOne(Petugas::class); }
            $petugasRecord = $user->petugas; 

            // Jika relasi null, coba cari manual di tabel petugas berdasarkan id_user
            if (!$petugasRecord) {
                // Ganti 'App\Models\Petugas' jika nama modelmu beda
                // Ganti 'id_user' jika kolom penghubungnya bernama lain (misal 'user_id')
                $petugasRecord = \App\Models\Petugas::where('id_user', $user->id)->first();
            }

            if (!$petugasRecord || empty($petugasRecord->id_petugas)) {
                 throw new \Exception("Akun Admin ini tidak terdaftar sebagai Petugas aktif di sistem. Hubungi IT.");
            }

            // Sekarang kita yakin variabel ini berisi ID yang valid menurut Foreign Key Database
            $finalPetugasId = $petugasRecord->id_petugas;


            // ---------------------------------------------------------
            // 2. HITUNG ULANG DATA REAL-TIME
            // ---------------------------------------------------------
            $totalJasaMasuk = Angsuran::whereBetween('tanggal_pembayaran', [$startMonth, $endMonth])
                ->sum('jumlah_jasa');

            if ($totalJasaMasuk <= 0) {
                throw new \Exception("Tidak ada jasa/penghasilan pada periode {$periodeStr}.");
            }

            $danaDibagikan = $totalJasaMasuk * 0.20; 

            // Ambil ulang data nasabah
            $nasabahs = Nasabah::whereHas('rekening', function($q) {
                $q->where('saldo', '>', 0);
            })->with('rekening')->get();
            
            $totalSaldoNasabah = $nasabahs->sum(fn($n) => $n->rekening->saldo);

            if ($totalSaldoNasabah <= 0) {
                throw new \Exception("Total saldo nasabah nol.");
            }

            // 3. Keamanan: Cek apakah sudah pernah diproses bulan ini?
            $cekProses = DetailTabungan::where('keterangan', "Bagi Hasil Periode {$periodeStr}")
                ->exists();
            
            if ($cekProses) {
                throw new \Exception("Data bagi hasil untuk periode {$periodeStr} SUDAH DIPROSES sebelumnya.");
            }

            // 4. Looping Pembagian & Update
            foreach ($nasabahs as $nasabah) {
                $rek = $nasabah->rekening;
                
                if ($totalSaldoNasabah == 0) continue;

                $porsi = $rek->saldo / $totalSaldoNasabah;
                $bagianUang = round($danaDibagikan * $porsi);

                if ($bagianUang > 0) {
                    // A. UPDATE SALDO
                    $newSaldo = $rek->saldo + $bagianUang;
                    $rek->update(['saldo' => $newSaldo]);

                    // B. CATAT TRANSAKSI
                    DetailTabungan::create([
                        'no_rek' => $rek->no_rek,
                        'id_petugas' => $finalPetugasId, // <--- INI KUNCINYA! Menggunakan ID dari tabel petugas
                        'id_jenis_transaksi' => 1,
                        'jumlah' => $bagianUang,
                        'status' => 'berhasil',
                        'tanggal_transaksi' => now(),
                        'keterangan' => "Bagi Hasil Periode {$periodeStr}",
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.update.saldo.index', ['periode' => $periodeStr])
                ->with('success', "Sukses! Bagi hasil periode {$periodeStr} telah didistribusikan ke {$nasabahs->count()} nasabah.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses bagi hasil: ' . $e->getMessage());
        }
    }
}