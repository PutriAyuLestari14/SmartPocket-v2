<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Angsuran;
use App\Models\DetailTabungan;
use App\Models\Nasabah;
use App\Models\Petugas;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminUpdateSaldoController extends Controller
{
    /**
     * Halaman Preview Bagi Hasil.
     */
    public function index(Request $request)
    {
        $periodeStr = $request->get('periode', now()->format('Y-m'));

        try {
            $periode = Carbon::createFromFormat('!Y-m', $periodeStr);

            if (!$periode || $periode->format('Y-m') !== $periodeStr) {
                return back()->with('error', 'Format bulan tidak valid.');
            }

            $startMonth = $periode->copy()->startOfMonth();
            $endMonth = $periode->copy()->endOfMonth();
        } catch (\Exception $e) {
            return back()->with('error', 'Format bulan tidak valid.');
        }

        Carbon::setLocale('id');

        $namaBulan = $periode->translatedFormat('F');
        $keteranganUnik = "Bagi Hasil Bulan {$namaBulan}";
        $labelPeriodeLama = "Bagi Hasil Periode {$periodeStr}";

        /*
         * Cek apakah periode sudah dibagikan.
         * Kenali label baru dan label lama.
         */
        $sudahDiproses = DetailTabungan::whereBetween(
            'tanggal_transaksi',
            [$startMonth, $endMonth]
        )
            ->whereIn('keterangan', [
                $keteranganUnik,
                $labelPeriodeLama,
            ])
            ->exists();

        /*
         * Hitung total jasa angsuran berdasarkan
         * tanggal pembayaran pada periode terpilih.
         */
        $totalJasaMasuk = Angsuran::whereBetween(
            'tanggal_pembayaran',
            [$startMonth, $endMonth]
        )->sum('jumlah_jasa');

        $persentaseBagiHasil = 20;

        /*
         * Bulan berjalan dan bulan mendatang
         * tidak boleh diproses.
         */
        $periodeBelumSelesai =
            $periode->format('Y-m') > now()->format('Y-m');

        if (
            $sudahDiproses ||
            $periodeBelumSelesai ||
            $totalJasaMasuk <= 0
        ) {
            $danaDibagikan = 0;
        } else {
            $danaDibagikan = $totalJasaMasuk
                * ($persentaseBagiHasil / 100);
        }

        /*
         * Ambil nasabah dengan rekening bersaldo positif.
         */
        $nasabahs = Nasabah::whereHas('rekening', function ($query) {
            $query->where('saldo', '>', 0);
        })
            ->with('rekening')
            ->get();

        $totalSaldoNasabah = $nasabahs->sum(function ($nasabah) {
            return $nasabah->rekening->saldo ?? 0;
        });

        /*
         * Simulasi pembagian secara proporsional.
         */
        $simulasiPembagian = [];

        if (
            !$sudahDiproses &&
            !$periodeBelumSelesai &&
            $totalJasaMasuk > 0 &&
            $danaDibagikan > 0 &&
            $totalSaldoNasabah > 0
        ) {
            foreach ($nasabahs as $nasabah) {
                $rekening = $nasabah->rekening;

                if (!$rekening || $rekening->saldo <= 0) {
                    continue;
                }

                $porsi = $rekening->saldo / $totalSaldoNasabah;

                $simulasiPembagian[] = [
                    'id_nasabah' => $nasabah->id_nasabah,
                    'no_rek' => $rekening->no_rek,
                    'nama_nasabah' => $nasabah->nama ?? 'Tanpa Nama',
                    'saldo_sekarang' => $rekening->saldo,
                    'porsi_persen' => number_format($porsi * 100, 2),
                    'estimasi_bagian' => (int) round(
                        $danaDibagikan * $porsi
                    ),
                ];
            }
        }

        return view('admin.saldo.index', compact(
            'periodeStr',
            'totalJasaMasuk',
            'danaDibagikan',
            'persentaseBagiHasil',
            'sudahDiproses',
            'periodeBelumSelesai',
            'simulasiPembagian',
            'nasabahs'
        ));
    }

    /**
     * Eksekusi Proses Bagi Hasil.
     */
    public function store(Request $request)
    {
        $request->validate([
            'periode' => 'required|date_format:Y-m',
        ]);

        $periodeStr = $request->input('periode');

        try {
            $periode = Carbon::createFromFormat('!Y-m', $periodeStr);

            if (!$periode || $periode->format('Y-m') !== $periodeStr) {
                return back()->with('error', 'Format periode tidak valid.');
            }

            $startMonth = $periode->copy()->startOfMonth();
            $endMonth = $periode->copy()->endOfMonth();
        } catch (\Exception $e) {
            return back()->with('error', 'Format periode tidak valid.');
        }

        /*
        * Tolak hanya periode bulan mendatang.
        * Bulan berjalan tetap boleh diproses.
        */
        if ($periode->format('Y-m') > now()->format('Y-m')) {
            return back()->with(
                'error',
                'Bagi hasil untuk bulan mendatang belum dapat diproses.'
            );
        }

        Carbon::setLocale('id');

        $namaBulan = $periode->translatedFormat('F');
        $keteranganUnik = "Bagi Hasil Bulan {$namaBulan}";
        $labelPeriodeLama = "Bagi Hasil Periode {$periodeStr}";

        DB::beginTransaction();

        try {
            /*
             * 1. Pastikan admin sudah login dan terdaftar
             * sebagai petugas.
             */
            $user = auth()->user();

            if (!$user) {
                throw new \Exception(
                    'Sesi berakhir. Silakan login kembali.'
                );
            }

            $petugasRecord = $user->petugas;

            if (!$petugasRecord) {
                $petugasRecord = Petugas::where(
                    'id_user',
                    $user->id
                )->first();
            }

            if (!$petugasRecord || empty($petugasRecord->id_petugas)) {
                throw new \Exception(
                    'Akun Admin ini tidak terdaftar sebagai Petugas aktif di sistem. Hubungi IT.'
                );
            }

            $finalPetugasId = $petugasRecord->id_petugas;

            /*
             * 2. Cek transaksi yang sudah ada.
             * Pengecekan ini mencakup label baru dan lama.
             */
            $cekProses = DetailTabungan::whereBetween(
                'tanggal_transaksi',
                [$startMonth, $endMonth]
            )
                ->whereIn('keterangan', [
                    $keteranganUnik,
                    $labelPeriodeLama,
                ])
                ->lockForUpdate()
                ->exists();

            if ($cekProses) {
                throw new \Exception(
                    "Bagi hasil periode {$periodeStr} sudah pernah diproses. Saldo tidak ditambahkan lagi."
                );
            }

            /*
             * 3. Hitung total jasa angsuran pada bulan terpilih.
             */
            $totalJasaMasuk = Angsuran::whereBetween(
                'tanggal_pembayaran',
                [$startMonth, $endMonth]
            )->sum('jumlah_jasa');

            if ($totalJasaMasuk <= 0) {
                throw new \Exception(
                    "Tidak ada jasa/penghasilan pada periode {$periodeStr}."
                );
            }

            /*
             * 4. Tentukan dana yang dibagikan sebesar 20%.
             */
            $danaDibagikan = $totalJasaMasuk * 0.20;

            /*
             * 5. Ambil rekening nasabah dengan saldo positif.
             */
            $nasabahs = Nasabah::whereHas('rekening', function ($query) {
                $query->where('saldo', '>', 0);
            })
                ->with('rekening')
                ->get();

            $totalSaldoNasabah = $nasabahs->sum(function ($nasabah) {
                return $nasabah->rekening->saldo ?? 0;
            });

            if ($totalSaldoNasabah <= 0) {
                throw new \Exception('Total saldo nasabah nol.');
            }

            /*
             * 6. Distribusikan dana secara proporsional.
             */
            $jumlahPenerima = 0;
            $totalTerealisasi = 0;

            foreach ($nasabahs as $nasabah) {
                $rekening = $nasabah->rekening;

                if (!$rekening || $rekening->saldo <= 0) {
                    continue;
                }

                $porsi = $rekening->saldo / $totalSaldoNasabah;

                $bagianUang = (int) round(
                    $danaDibagikan * $porsi
                );

                if ($bagianUang <= 0) {
                    continue;
                }

                /*
                 * A. Tambahkan bagian bagi hasil ke saldo rekening.
                 */
                $rekening->update([
                    'saldo' => $rekening->saldo + $bagianUang,
                ]);

                /*
                 * B. Simpan riwayat transaksi.
                 * Tanggal menggunakan akhir bulan yang dibagikan.
                 */
                DetailTabungan::create([
                    'no_rek' => $rekening->no_rek,
                    'id_petugas' => $finalPetugasId,
                    'id_jenis_transaksi' => 1,
                    'jumlah' => $bagianUang,
                    'status' => 'berhasil',
                    'tanggal_transaksi' => $endMonth->toDateString(),
                    'keterangan' => $keteranganUnik,
                ]);

                $jumlahPenerima++;
                $totalTerealisasi += $bagianUang;
            }

            if ($jumlahPenerima === 0) {
                throw new \Exception(
                    'Tidak ada nasabah yang menerima bagi hasil.'
                );
            }

            DB::commit();

            return redirect()
                ->route('admin.update.saldo.index', [
                    'periode' => $periodeStr,
                ])
                ->with(
                    'success',
                    "Sukses! Bagi hasil bulan {$namaBulan} telah dicatat untuk {$jumlahPenerima} nasabah. Total terealisasi: Rp"
                    . number_format($totalTerealisasi, 0, ',', '.')
                );

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with(
                'error',
                'Gagal memproses bagi hasil: ' . $e->getMessage()
            );
        }
    }
}
