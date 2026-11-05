<?php

namespace App\Http\Controllers;

use App\Models\DetailTabungan;
use App\Models\Peminjaman;
use App\Models\Angsuran;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminLaporanController extends Controller
{
    private function hitungLaporanNeraca($tanggalMulai, $tanggalSelesai)
    {
        $akun = [
            '1-1100' => [
                'kode' => '1-1100',
                'nama' => 'Kas',
                'normal' => 'debit',
                'awal_debit' => 0,
                'awal_kredit' => 0,
                'mutasi_debit' => 0,
                'mutasi_kredit' => 0,
            ],
            '1-1200' => [
                'kode' => '1-1200',
                'nama' => 'Piutang',
                'normal' => 'debit',
                'awal_debit' => 0,
                'awal_kredit' => 0,
                'mutasi_debit' => 0,
                'mutasi_kredit' => 0,
            ],
            '2-2100' => [
                'kode' => '2-2100',
                'nama' => 'Tabungan',
                'normal' => 'kredit',
                'awal_debit' => 0,
                'awal_kredit' => 0,
                'mutasi_debit' => 0,
                'mutasi_kredit' => 0,
            ],
            '4-1100' => [
                'kode' => '4-1100',
                'nama' => 'Pendapatan Usaha',
                'normal' => 'kredit',
                'awal_debit' => 0,
                'awal_kredit' => 0,
                'mutasi_debit' => 0,
                'mutasi_kredit' => 0,
            ],
            '4-1200' => [
                'kode' => '4-1200',
                'nama' => 'Pendapatan Provisi',
                'normal' => 'kredit',
                'awal_debit' => 0,
                'awal_kredit' => 0,
                'mutasi_debit' => 0,
                'mutasi_kredit' => 0,
            ],
            '4-1300' => [
                'kode' => '4-1300',
                'nama' => 'Pendapatan Lain-lain',
                'normal' => 'kredit',
                'awal_debit' => 0,
                'awal_kredit' => 0,
                'mutasi_debit' => 0,
                'mutasi_kredit' => 0,
            ],
        ];

        // =========================================================
        // 1. TRANSAKSI SEBELUM PERIODE: SALDO AWAL
        // =========================================================

        $tabunganSebelum = DetailTabungan::where(
            'tanggal_transaksi',
            '<',
            $tanggalMulai
        )
            ->where('status', 'berhasil')
            ->get();

        $pinjamanSebelum = Peminjaman::where(
            'tanggal_ajuan',
            '<',
            $tanggalMulai
        )
            ->where('status_verifikasi', 'disetujui')
            ->get();

        $angsuranSebelum = Angsuran::where(
            'tanggal_pembayaran',
            '<',
            $tanggalMulai
        )->get();

        foreach ($tabunganSebelum as $transaksi) {
            $jumlah = (float) $transaksi->jumlah;
            $keteranganAsli = strtolower(
                trim($transaksi->keterangan ?? '')
            );

            // Pendapatan biaya buku tabungan
            if (
                str_contains($keteranganAsli, 'biaya buku tabungan') ||
                str_contains($keteranganAsli, 'pembayaran buku tabungan')
            ) {
                $akun['1-1100']['awal_debit'] += $jumlah;
                $akun['4-1300']['awal_kredit'] += $jumlah;

                continue;
            }

            // Pemindahan saldo mengendap ke pendapatan usaha
            if (
                str_contains(
                    $keteranganAsli,
                    'pemindahan saldo mengendap ke pendapatan usaha'
                )
            ) {
                $akun['2-2100']['awal_debit'] += $jumlah;
                $akun['4-1100']['awal_kredit'] += $jumlah;

                continue;
            }

            // Setoran tabungan
            if ((int) $transaksi->id_jenis_transaksi === 1) {
                $akun['1-1100']['awal_debit'] += $jumlah;
                $akun['2-2100']['awal_kredit'] += $jumlah;
            }
            // Penarikan tabungan
            elseif ((int) $transaksi->id_jenis_transaksi === 2) {
                $akun['2-2100']['awal_debit'] += $jumlah;
                $akun['1-1100']['awal_kredit'] += $jumlah;
            }
        }

        // Peminjaman sebelum periode
        foreach ($pinjamanSebelum as $pinjaman) {
            $jumlahPinjaman = (float) $pinjaman->jumlah_pinjaman;
            $provisi = $jumlahPinjaman * 0.01;
            $kasDikeluarkan = $jumlahPinjaman - $provisi;

            $akun['1-1200']['awal_debit'] += $jumlahPinjaman;
            $akun['1-1100']['awal_kredit'] += $kasDikeluarkan;
            $akun['4-1200']['awal_kredit'] += $provisi;
        }

        // Angsuran sebelum periode
        foreach ($angsuranSebelum as $angsuran) {
            $pokok = (float) $angsuran->jumlah_pokok;
            $jasa = (float) $angsuran->jumlah_jasa;

            $akun['1-1100']['awal_debit'] += $pokok + $jasa;
            $akun['1-1200']['awal_kredit'] += $pokok;
            $akun['4-1100']['awal_kredit'] += $jasa;
        }

        // Normalisasi saldo awal berdasarkan saldo bersih
        foreach ($akun as &$item) {
            $saldoBersih = $item['awal_debit'] - $item['awal_kredit'];

            $item['awal_debit'] = max($saldoBersih, 0);
            $item['awal_kredit'] = max(-$saldoBersih, 0);
        }

        unset($item);

        // =========================================================
        // 2. TRANSAKSI PERIODE BERJALAN: MUTASI
        // =========================================================

        $tabungan = DetailTabungan::whereBetween(
            'tanggal_transaksi',
            [$tanggalMulai, $tanggalSelesai]
        )
            ->where('status', 'berhasil')
            ->get();

        $peminjaman = Peminjaman::where(
            'status_verifikasi',
            'disetujui'
        )
            ->whereBetween(
                'tanggal_ajuan',
                [$tanggalMulai, $tanggalSelesai]
            )
            ->get();

        $angsuran = Angsuran::whereBetween(
            'tanggal_pembayaran',
            [$tanggalMulai, $tanggalSelesai]
        )->get();

        foreach ($tabungan as $transaksi) {
            $jumlah = (float) $transaksi->jumlah;
            $keteranganAsli = strtolower(
                trim($transaksi->keterangan ?? '')
            );

            // Pendapatan biaya buku tabungan Rp5.000
            if (
                str_contains($keteranganAsli, 'biaya buku tabungan') ||
                str_contains($keteranganAsli, 'pembayaran buku tabungan')
            ) {
                $akun['1-1100']['mutasi_debit'] += $jumlah;
                $akun['4-1300']['mutasi_kredit'] += $jumlah;

                continue;
            }

            // Pemindahan saldo mengendap ke pendapatan usaha
            if (
                str_contains(
                    $keteranganAsli,
                    'pemindahan saldo mengendap ke pendapatan usaha'
                )
            ) {
                $akun['2-2100']['mutasi_debit'] += $jumlah;
                $akun['4-1100']['mutasi_kredit'] += $jumlah;

                continue;
            }

            // Setoran tabungan
            if ((int) $transaksi->id_jenis_transaksi === 1) {
                $akun['1-1100']['mutasi_debit'] += $jumlah;
                $akun['2-2100']['mutasi_kredit'] += $jumlah;
            }
            // Penarikan tabungan
            elseif ((int) $transaksi->id_jenis_transaksi === 2) {
                $akun['2-2100']['mutasi_debit'] += $jumlah;
                $akun['1-1100']['mutasi_kredit'] += $jumlah;
            }
        }

        // Peminjaman periode berjalan
        foreach ($peminjaman as $pinjaman) {
            $jumlahPinjaman = (float) $pinjaman->jumlah_pinjaman;
            $provisi = $jumlahPinjaman * 0.01;
            $kasDikeluarkan = $jumlahPinjaman - $provisi;

            $akun['1-1200']['mutasi_debit'] += $jumlahPinjaman;
            $akun['1-1100']['mutasi_kredit'] += $kasDikeluarkan;
            $akun['4-1200']['mutasi_kredit'] += $provisi;
        }

        // Angsuran periode berjalan
        foreach ($angsuran as $item) {
            $pokok = (float) $item->jumlah_pokok;
            $jasa = (float) $item->jumlah_jasa;

            $akun['1-1100']['mutasi_debit'] += $pokok + $jasa;
            $akun['1-1200']['mutasi_kredit'] += $pokok;
            $akun['4-1100']['mutasi_kredit'] += $jasa;
        }

        // =========================================================
        // 3. HITUNG SALDO AKHIR
        // =========================================================

        foreach ($akun as &$item) {
            if ($item['normal'] === 'debit') {
                $saldo =
                    $item['awal_debit']
                    - $item['awal_kredit']
                    + $item['mutasi_debit']
                    - $item['mutasi_kredit'];

                $item['akhir_debit'] = $saldo >= 0 ? $saldo : 0;
                $item['akhir_kredit'] = $saldo < 0 ? abs($saldo) : 0;
            } else {
                $saldo =
                    $item['awal_kredit']
                    - $item['awal_debit']
                    + $item['mutasi_kredit']
                    - $item['mutasi_debit'];

                $item['akhir_debit'] = $saldo < 0 ? abs($saldo) : 0;
                $item['akhir_kredit'] = $saldo >= 0 ? $saldo : 0;
            }
        }

        unset($item);

        return [
            'akun' => $akun,
            'totalAwalDebit' => collect($akun)->sum('awal_debit'),
            'totalAwalKredit' => collect($akun)->sum('awal_kredit'),
            'totalMutasiDebit' => collect($akun)->sum('mutasi_debit'),
            'totalMutasiKredit' => collect($akun)->sum('mutasi_kredit'),
            'totalAkhirDebit' => collect($akun)->sum('akhir_debit'),
            'totalAkhirKredit' => collect($akun)->sum('akhir_kredit'),
        ];
    }

    public function index(Request $request)
    {
        $periode = $request->periode ?? now()->format('Y-m');

        $tanggalMulai = Carbon::createFromFormat(
            'Y-m',
            $periode
        )->startOfMonth();

        $tanggalSelesai = $tanggalMulai->copy()->endOfMonth();

        $data = $this->hitungLaporanNeraca(
            $tanggalMulai,
            $tanggalSelesai
        );

        return view(
            'admin.laporan.index',
            array_merge(
                compact('periode', 'tanggalMulai', 'tanggalSelesai'),
                $data
            )
        );
    }

    public function exportNeraca(Request $request)
    {
        $periode = $request->periode ?? now()->format('Y-m');

        $tanggalMulai = Carbon::createFromFormat(
            'Y-m',
            $periode
        )->startOfMonth();

        $tanggalSelesai = $tanggalMulai->copy()->endOfMonth();

        $data = $this->hitungLaporanNeraca(
            $tanggalMulai,
            $tanggalSelesai
        );

        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' =>
                'attachment; filename="Neraca_BMT_' . $periode . '.xls"',
            'Pragma' => 'no-cache',
        ];

        return response()
            ->view(
                'admin.laporan.export-neraca',
                array_merge(
                    compact('periode', 'tanggalMulai', 'tanggalSelesai'),
                    $data
                )
            )
            ->withHeaders($headers);
    }
}
