<?php

namespace App\Http\Controllers;

use App\Models\DetailTabungan;
use App\Models\Peminjaman;
use App\Models\Angsuran;
use Illuminate\Http\Request;

class OperatorLaporanController extends Controller
{
    public function index(Request $request)
    {
        $tanggalMulai = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_akhir;
        $jenis = $request->jenis ?? 'semua';

        $laporan = collect();

        /*
        |--------------------------------------------------------------------------
        | TABUNGAN
        |--------------------------------------------------------------------------
        */

        if ($jenis === 'semua' || $jenis === 'tabungan') {

            $tabungan = DetailTabungan::query()

                ->when($tanggalMulai, function ($query) use ($tanggalMulai) {
                    $query->whereDate(
                        'tanggal_transaksi',
                        '>=',
                        $tanggalMulai
                    );
                })

                ->when($tanggalSelesai, function ($query) use ($tanggalSelesai) {
                    $query->whereDate(
                        'tanggal_transaksi',
                        '<=',
                        $tanggalSelesai
                    );
                })

                ->orderBy('tanggal_transaksi', 'desc')
                ->get();

            foreach ($tabungan as $item) {

                // SETORAN
                if ((int) $item->id_jenis_transaksi === 1) {

                    $laporan->push([
                        'tanggal' => $item->tanggal_transaksi,
                        'jenis' => 'Tabungan',
                        'debit' => (int) $item->jumlah,
                        'kredit' => 0,
                    ]);
                }

                // PENARIKAN
                elseif ((int) $item->id_jenis_transaksi === 2) {

                    $laporan->push([
                        'tanggal' => $item->tanggal_transaksi,
                        'jenis' => 'Tabungan',
                        'debit' => 0,
                        'kredit' => (int) $item->jumlah,
                    ]);
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | PEMINJAMAN
        |--------------------------------------------------------------------------
        */

        if (
            $jenis === 'semua' ||
            $jenis === 'peminjaman' ||
            $jenis === 'provisi' ||
            $jenis === 'kas'
        ) {

            $peminjamans = Peminjaman::where(
                'status_verifikasi',
                'disetujui'
            )

            ->when($tanggalMulai, function ($query) use ($tanggalMulai) {
                $query->whereDate(
                    'tanggal_ajuan',
                    '>=',
                    $tanggalMulai
                );
            })

            ->when($tanggalSelesai, function ($query) use ($tanggalSelesai) {
                $query->whereDate(
                    'tanggal_ajuan',
                    '<=',
                    $tanggalSelesai
                );
            })

            ->orderBy('tanggal_ajuan', 'desc')
            ->get();


            foreach ($peminjamans as $pinjaman) {

                $provisi = (int) ($pinjaman->jumlah_pinjaman * 0.01);

                $kasDiterima =
                    (int) $pinjaman->jumlah_pinjaman - $provisi;


                // UANG PINJAMAN KELUAR
                if (
                    $jenis === 'semua' ||
                    $jenis === 'peminjaman'
                ) {

                    $laporan->push([
                        'tanggal' => $pinjaman->tanggal_ajuan,
                        'jenis' => 'Peminjaman',
                        'debit' => 0,
                        'kredit' => $kasDiterima,
                    ]);
                }


                // PROVISI MASUK
                if (
                    $jenis === 'semua' ||
                    $jenis === 'provisi'
                ) {

                    $laporan->push([
                        'tanggal' => $pinjaman->tanggal_ajuan,
                        'jenis' => 'Provisi',
                        'debit' => $provisi,
                        'kredit' => 0,
                    ]);
                }


                // KAS KELUAR
                if (
                    $jenis === 'semua' ||
                    $jenis === 'kas'
                ) {

                    $laporan->push([
                        'tanggal' => $pinjaman->tanggal_ajuan,
                        'jenis' => 'Kas',
                        'debit' => 0,
                        'kredit' => $kasDiterima,
                    ]);
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | ANGSURAN
        |--------------------------------------------------------------------------
        */

        if (
            $jenis === 'semua' ||
            $jenis === 'peminjaman' ||
            $jenis === 'jasa'
        ) {

            $angsuran = Angsuran::query()

                ->when($tanggalMulai, function ($query) use ($tanggalMulai) {
                    $query->whereDate(
                        'tanggal_pembayaran',
                        '>=',
                        $tanggalMulai
                    );
                })

                ->when($tanggalSelesai, function ($query) use ($tanggalSelesai) {
                    $query->whereDate(
                        'tanggal_pembayaran',
                        '<=',
                        $tanggalSelesai
                    );
                })

                ->orderBy('tanggal_pembayaran', 'desc')
                ->get();


            foreach ($angsuran as $item) {

                // POKOK
                if (
                    ($jenis === 'semua' ||
                     $jenis === 'peminjaman') &&
                    (int) $item->jumlah_pokok > 0
                ) {

                    $laporan->push([
                        'tanggal' => $item->tanggal_pembayaran,
                        'jenis' => 'Peminjaman',
                        'debit' => (int) $item->jumlah_pokok,
                        'kredit' => 0,
                    ]);
                }


                // JASA
                if (
                    ($jenis === 'semua' ||
                     $jenis === 'jasa') &&
                    (int) $item->jumlah_jasa > 0
                ) {

                    $laporan->push([
                        'tanggal' => $item->tanggal_pembayaran,
                        'jenis' => 'Jasa',
                        'debit' => (int) $item->jumlah_jasa,
                        'kredit' => 0,
                    ]);
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | TOTAL
        |--------------------------------------------------------------------------
        */

        $laporan = $laporan
            ->sortByDesc('tanggal')
            ->values();

        $totalDebit = $laporan->sum('debit');
        $totalKredit = $laporan->sum('kredit');


        return view('operator.laporan.index', compact(
            'laporan',
            'tanggalMulai',
            'tanggalSelesai',
            'jenis',
            'totalDebit',
            'totalKredit'
        ));
    }
}