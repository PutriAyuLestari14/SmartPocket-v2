<?php

namespace App\Http\Controllers;

use App\Models\DetailTabungan;
use App\Models\Peminjaman;
use App\Models\Angsuran;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminLaporanController extends Controller
{
    public function index(Request $request)
    {
        // ambil periode laporan
        $periode = $request->periode ?? now()->format('Y-m');

        $tanggalMulai = Carbon::createFromFormat(
            'Y-m',
            $periode
        )->startOfMonth();

        $tanggalSelesai = $tanggalMulai->copy()->endOfMonth();

        // daftar 6 akun smartpocket
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

        // ambil transaksi sebelum periode
        $tabunganSebelum = DetailTabungan::where(
            'tanggal_transaksi',
            '<',
            $tanggalMulai
        )
            ->where('status', '!=', 'pending')
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

        // hitung neraca awal
        foreach ($tabunganSebelum as $transaksi) {
            $jumlah = (float) $transaksi->jumlah;

            // setoran
            if ($transaksi->id_jenis_transaksi == 1) {
                $akun['1-1100']['awal_debit'] += $jumlah;
                $akun['2-2100']['awal_kredit'] += $jumlah;
            }

            // penarikan
            elseif ($transaksi->id_jenis_transaksi == 2) {
                $akun['2-2100']['awal_debit'] += $jumlah;
                $akun['1-1100']['awal_kredit'] += $jumlah;
            }
        }

        foreach ($pinjamanSebelum as $pinjaman) {
            $jumlahPinjaman = (float) $pinjaman->jumlah_pinjaman;
            $provisi = $jumlahPinjaman * 0.01;
            $kasDikeluarkan = $jumlahPinjaman - $provisi;

            $akun['1-1200']['awal_debit'] += $jumlahPinjaman;
            $akun['1-1100']['awal_kredit'] += $kasDikeluarkan;
            $akun['4-1200']['awal_kredit'] += $provisi;
        }

        foreach ($angsuranSebelum as $angsuran) {
            $pokok = (float) $angsuran->jumlah_pokok;
            $jasa = (float) $angsuran->jumlah_jasa;

            $akun['1-1100']['awal_debit'] += $pokok + $jasa;
            $akun['1-1200']['awal_kredit'] += $pokok;
            $akun['4-1100']['awal_kredit'] += $jasa;
        }

        // ambil transaksi pada periode yang dipilih
        $tabungan = DetailTabungan::whereBetween(
            'tanggal_transaksi',
            [$tanggalMulai, $tanggalSelesai]
        )
            ->where('status', '!=', 'pending')
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

        // hitung mutasi tabungan
        foreach ($tabungan as $transaksi) {
        $jumlah = (float) $transaksi->jumlah;

        // setoran
        if ($transaksi->id_jenis_transaksi == 1) {
            $akun['1-1100']['mutasi_debit'] += $jumlah;
            $akun['2-2100']['mutasi_kredit'] += $jumlah;

            // pendapatan buku tabungan
            if (str_contains(strtolower($transaksi->keterangan ?? ''), 'buku tabungan')) {
                $biayaBuku = 5000;

                $akun['1-1100']['mutasi_debit'] += $biayaBuku;
                $akun['4-1300']['mutasi_kredit'] += $biayaBuku;
            }
        }

        // penarikan
        elseif ($transaksi->id_jenis_transaksi == 2) {
            $akun['2-2100']['mutasi_debit'] += $jumlah;
            $akun['1-1100']['mutasi_kredit'] += $jumlah;
        }
    }

        // hitung mutasi pinjaman
        foreach ($peminjaman as $pinjaman) {
            $jumlahPinjaman = (float) $pinjaman->jumlah_pinjaman;
            $provisi = $jumlahPinjaman * 0.01;
            $kasDikeluarkan = $jumlahPinjaman - $provisi;

            // piutang bertambah
            $akun['1-1200']['mutasi_debit'] += $jumlahPinjaman;

            // kas keluar
            $akun['1-1100']['mutasi_kredit'] += $kasDikeluarkan;

            // pendapatan provisi
            $akun['4-1200']['mutasi_kredit'] += $provisi;
        }

        // hitung mutasi angsuran
        foreach ($angsuran as $item) {
            $pokok = (float) $item->jumlah_pokok;
            $jasa = (float) $item->jumlah_jasa;

            // kas masuk
            $akun['1-1100']['mutasi_debit'] += $pokok + $jasa;

            // piutang berkurang
            $akun['1-1200']['mutasi_kredit'] += $pokok;

            // pendapatan jasa
            $akun['4-1100']['mutasi_kredit'] += $jasa;
        }

        // hitung saldo akhir
        foreach ($akun as $kode => &$item) {
            if ($item['normal'] === 'debit') {
                $saldo =
                    $item['awal_debit']
                    - $item['awal_kredit']
                    + $item['mutasi_debit']
                    - $item['mutasi_kredit'];

                if ($saldo >= 0) {
                    $item['akhir_debit'] = $saldo;
                    $item['akhir_kredit'] = 0;
                } else {
                    $item['akhir_debit'] = 0;
                    $item['akhir_kredit'] = abs($saldo);
                }
            } else {
                $saldo =
                    $item['awal_kredit']
                    - $item['awal_debit']
                    + $item['mutasi_kredit']
                    - $item['mutasi_debit'];

                if ($saldo >= 0) {
                    $item['akhir_debit'] = 0;
                    $item['akhir_kredit'] = $saldo;
                } else {
                    $item['akhir_debit'] = abs($saldo);
                    $item['akhir_kredit'] = 0;
                }
            }
        }

        unset($item);

        // hitung total
        $totalAwalDebit = collect($akun)->sum('awal_debit');
        $totalAwalKredit = collect($akun)->sum('awal_kredit');
        $totalMutasiDebit = collect($akun)->sum('mutasi_debit');
        $totalMutasiKredit = collect($akun)->sum('mutasi_kredit');
        $totalAkhirDebit = collect($akun)->sum('akhir_debit');
        $totalAkhirKredit = collect($akun)->sum('akhir_kredit');

        // kirim data ke halaman laporan
        return view('admin.laporan.index', compact(
            'periode',
            'tanggalMulai',
            'tanggalSelesai',
            'akun',
            'totalAwalDebit',
            'totalAwalKredit',
            'totalMutasiDebit',
            'totalMutasiKredit',
            'totalAkhirDebit',
            'totalAkhirKredit'
        ));
    }
}