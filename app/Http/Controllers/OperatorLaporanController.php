<?php

namespace App\Http\Controllers;

use App\Models\DetailTabungan;
use App\Models\Peminjaman;
use App\Models\Angsuran;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class OperatorLaporanController extends Controller
{
    public function index(Request $request)
    {
        $tanggalMulai = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_akhir;
        $jenis = $request->jenis ?? 'semua';

        // Kita gunakan Collection untuk menampung entri jurnal
        $jurnalEntries = collect();

        /*
        |--------------------------------------------------------------------------
        | 1. TRANSAKSI TABUNGAN (Setor & Tarik)
        |--------------------------------------------------------------------------
        */
        if ($jenis === 'semua' || $jenis === 'tabungan') {
            $tabungans = DetailTabungan::query()
                ->when($tanggalMulai, fn($q) => $q->whereDate('tanggal_transaksi', '>=', $tanggalMulai))
                ->when($tanggalSelesai, fn($q) => $q->whereDate('tanggal_transaksi', '<=', $tanggalSelesai))
                ->orderBy('tanggal_transaksi', 'desc')
                ->get();

            foreach ($tabungans as $item) {
                $noBukti = 'TAB-' . $item->id;
                $tanggal = $item->tanggal_transaksi;
                $jumlah = (int) $item->jumlah;
                $keterangan = (int) $item->id_jenis_transaksi === 1 ? 'Setoran Tabungan' : 'Penarikan Tabungan';

                if ((int) $item->id_jenis_transaksi === 1) { // SETORAN
                    // Debit: Kas bertambah
                    $jurnalEntries->push([
                        'no_bukti' => $noBukti,
                        'tanggal' => $tanggal,
                        'akun' => 'Kas',
                        'debit' => $jumlah,
                        'kredit' => 0,
                        'keterangan' => $keterangan,
                    ]);
                    // Kredit: Kewajiban Tabungan Nasabah bertambah
                    $jurnalEntries->push([
                        'no_bukti' => $noBukti,
                        'tanggal' => $tanggal,
                        'akun' => 'Tabungan Nasabah',
                        'debit' => 0,
                        'kredit' => $jumlah,
                        'keterangan' => $keterangan,
                    ]);
                } else { // PENARIKAN
                    // Debit: Kewajiban Tabungan Nasabah berkurang
                    $jurnalEntries->push([
                        'no_bukti' => $noBukti,
                        'tanggal' => $tanggal,
                        'akun' => 'Tabungan Nasabah',
                        'debit' => $jumlah,
                        'kredit' => 0,
                        'keterangan' => $keterangan,
                    ]);
                    // Kredit: Kas berkurang
                    $jurnalEntries->push([
                        'no_bukti' => $noBukti,
                        'tanggal' => $tanggal,
                        'akun' => 'Kas',
                        'debit' => 0,
                        'kredit' => $jumlah,
                        'keterangan' => $keterangan,
                    ]);
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 2. TRANSAKSI PEMINJAMAN (Pencairan)
        |--------------------------------------------------------------------------
        */
        if ($jenis === 'semua' || $jenis === 'peminjaman') {
            $peminjamans = Peminjaman::where('status_verifikasi', 'disetujui')
                ->when($tanggalMulai, fn($q) => $q->whereDate('tanggal_ajuan', '>=', $tanggalMulai))
                ->when($tanggalSelesai, fn($q) => $q->whereDate('tanggal_ajuan', '<=', $tanggalSelesai))
                ->orderBy('tanggal_ajuan', 'desc')
                ->get();

            foreach ($peminjamans as $pinjaman) {
                $noBukti = 'PIN-' . $pinjaman->id;
                $tanggal = $pinjaman->tanggal_ajuan;
                
                $jumlahPinjaman = (int) $pinjaman->jumlah_pinjaman;
                $provisi = (int) ($jumlahPinjaman * 0.01); // Asumsi 1%
                $kasDiterima = $jumlahPinjaman - $provisi;

                // 1. Debit: Piutang Pembiayaan (Hak tagih BMT sebesar full amount)
                $jurnalEntries->push([
                    'no_bukti' => $noBukti,
                    'tanggal' => $tanggal,
                    'akun' => 'Piutang Pembiayaan',
                    'debit' => $jumlahPinjaman,
                    'kredit' => 0,
                    'keterangan' => 'Pencairan Pinjaman',
                ]);

                // 2. Kredit: Pendapatan Provisi (Potongan di awal)
                $jurnalEntries->push([
                    'no_bukti' => $noBukti,
                    'tanggal' => $tanggal,
                    'akun' => 'Pendapatan Provisi',
                    'debit' => 0,
                    'kredit' => $provisi,
                    'keterangan' => 'Potongan Provisi',
                ]);

                // 3. Kredit: Kas (Uang yang benar-benar keluar ke nasabah)
                $jurnalEntries->push([
                    'no_bukti' => $noBukti,
                    'tanggal' => $tanggal,
                    'akun' => 'Kas',
                    'debit' => 0,
                    'kredit' => $kasDiterima,
                    'keterangan' => 'Pencairan Pinjaman',
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 3. TRANSAKSI ANGSURAN (Pembayaran Cicilan)
        |--------------------------------------------------------------------------
        */
        // Filter 'peminjaman' di UI sebaiknya juga menampilkan angsuran
        if ($jenis === 'semua' || $jenis === 'peminjaman' || $jenis === 'jasa') {
            $angsurans = Angsuran::query()
                ->when($tanggalMulai, fn($q) => $q->whereDate('tanggal_pembayaran', '>=', $tanggalMulai))
                ->when($tanggalSelesai, fn($q) => $q->whereDate('tanggal_pembayaran', '<=', $tanggalSelesai))
                ->orderBy('tanggal_pembayaran', 'desc')
                ->get();

            foreach ($angsurans as $item) {
                $noBukti = 'ANG-' . $item->id;
                $tanggal = $item->tanggal_pembayaran;
                
                $pokok = (int) $item->jumlah_pokok;
                $jasa = (int) $item->jumlah_jasa;
                $totalBayar = $pokok + $jasa;

                if ($totalBayar > 0) {
                    // 1. Debit: Kas (Uang masuk ke BMT)
                    $jurnalEntries->push([
                        'no_bukti' => $noBukti,
                        'tanggal' => $tanggal,
                        'akun' => 'Kas',
                        'debit' => $totalBayar,
                        'kredit' => 0,
                        'keterangan' => 'Pembayaran Angsuran',
                    ]);

                    // 2. Kredit: Piutang Pembiayaan (Mengurangi hutang nasabah)
                    if ($pokok > 0) {
                        $jurnalEntries->push([
                            'no_bukti' => $noBukti,
                            'tanggal' => $tanggal,
                            'akun' => 'Piutang Pembiayaan',
                            'debit' => 0,
                            'kredit' => $pokok,
                            'keterangan' => 'Pembayaran Pokok',
                        ]);
                    }

                    // 3. Kredit: Pendapatan Jasa (Keuntungan BMT)
                    if ($jasa > 0) {
                        $jurnalEntries->push([
                            'no_bukti' => $noBukti,
                            'tanggal' => $tanggal,
                            'akun' => 'Pendapatan Jasa',
                            'debit' => 0,
                            'kredit' => $jasa,
                            'keterangan' => 'Pembayaran Jasa',
                        ]);
                    }
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 4. PROSES FINAL: Grouping & Sorting
        |--------------------------------------------------------------------------
        */
        
        // Kelompokkan berdasarkan no_bukti agar 1 transaksi tampil sebagai 1 blok di Blade
        $jurnalData = $jurnalEntries
            ->groupBy('no_bukti')
            ->sortByDesc(function ($group) {
                return $group->first()['tanggal']; // Urutkan berdasarkan tanggal transaksi terbaru
            });

        // Hitung total keseluruhan (flatten dulu agar semua baris dihitung)
        $totalDebit = $jurnalEntries->sum('debit');
        $totalKredit = $jurnalEntries->sum('kredit');

        return view('operator.laporan.index', compact(
            'jurnalData', // Perhatikan: variabel ini diganti dari $laporan menjadi $jurnalData
            'tanggalMulai',
            'tanggalSelesai',
            'jenis',
            'totalDebit',
            'totalKredit'
        ));
    }

    public function export(Request $request)
{
    $tanggalMulai = $request->tanggal_mulai;
    $tanggalSelesai = $request->tanggal_akhir;
    $jenis = $request->jenis ?? 'semua';

    $jurnalEntries = collect();

    // --- LOGIKA DATA (SAMA PERSIS SEPERTI DI INDEX) ---
    if ($jenis === 'semua' || $jenis === 'tabungan') {
        $tabungans = DetailTabungan::query()
            ->when($tanggalMulai, fn($q) => $q->whereDate('tanggal_transaksi', '>=', $tanggalMulai))
            ->when($tanggalSelesai, fn($q) => $q->whereDate('tanggal_transaksi', '<=', $tanggalSelesai))
            ->get();
        foreach ($tabungans as $item) {
            $noBukti = 'TAB-' . $item->id;
            $jumlah = (int) $item->jumlah;
            $ket = (int) $item->id_jenis_transaksi === 1 ? 'Setoran Tabungan' : 'Penarikan Tabungan';
            if ((int) $item->id_jenis_transaksi === 1) {
                $jurnalEntries->push(['no_bukti' => $noBukti, 'tanggal' => $item->tanggal_transaksi, 'akun' => 'Kas', 'debit' => $jumlah, 'kredit' => 0, 'keterangan' => $ket]);
                $jurnalEntries->push(['no_bukti' => $noBukti, 'tanggal' => $item->tanggal_transaksi, 'akun' => 'Tabungan Nasabah', 'debit' => 0, 'kredit' => $jumlah, 'keterangan' => $ket]);
            } else {
                $jurnalEntries->push(['no_bukti' => $noBukti, 'tanggal' => $item->tanggal_transaksi, 'akun' => 'Tabungan Nasabah', 'debit' => $jumlah, 'kredit' => 0, 'keterangan' => $ket]);
                $jurnalEntries->push(['no_bukti' => $noBukti, 'tanggal' => $item->tanggal_transaksi, 'akun' => 'Kas', 'debit' => 0, 'kredit' => $jumlah, 'keterangan' => $ket]);
            }
        }
    }

    if ($jenis === 'semua' || $jenis === 'peminjaman') {
        $peminjamans = Peminjaman::where('status_verifikasi', 'disetujui')
            ->when($tanggalMulai, fn($q) => $q->whereDate('tanggal_ajuan', '>=', $tanggalMulai))
            ->when($tanggalSelesai, fn($q) => $q->whereDate('tanggal_ajuan', '<=', $tanggalSelesai))
            ->get();
        foreach ($peminjamans as $pinjaman) {
            $noBukti = 'PIN-' . $pinjaman->id;
            $jumlahPinjaman = (int) $pinjaman->jumlah_pinjaman;
            $provisi = (int) ($jumlahPinjaman * 0.01);
            $kasDiterima = $jumlahPinjaman - $provisi;
            $jurnalEntries->push(['no_bukti' => $noBukti, 'tanggal' => $pinjaman->tanggal_ajuan, 'akun' => 'Piutang Pembiayaan', 'debit' => $jumlahPinjaman, 'kredit' => 0, 'keterangan' => 'Pencairan Pinjaman']);
            $jurnalEntries->push(['no_bukti' => $noBukti, 'tanggal' => $pinjaman->tanggal_ajuan, 'akun' => 'Pendapatan Provisi', 'debit' => 0, 'kredit' => $provisi, 'keterangan' => 'Potongan Provisi']);
            $jurnalEntries->push(['no_bukti' => $noBukti, 'tanggal' => $pinjaman->tanggal_ajuan, 'akun' => 'Kas', 'debit' => 0, 'kredit' => $kasDiterima, 'keterangan' => 'Pencairan Pinjaman']);
        }
    }

    if ($jenis === 'semua' || $jenis === 'peminjaman' || $jenis === 'jasa') {
        $angsurans = Angsuran::query()
            ->when($tanggalMulai, fn($q) => $q->whereDate('tanggal_pembayaran', '>=', $tanggalMulai))
            ->when($tanggalSelesai, fn($q) => $q->whereDate('tanggal_pembayaran', '<=', $tanggalSelesai))
            ->get();
        foreach ($angsurans as $item) {
            $noBukti = 'ANG-' . $item->id;
            $pokok = (int) $item->jumlah_pokok;
            $jasa = (int) $item->jumlah_jasa;
            $totalBayar = $pokok + $jasa;
            if ($totalBayar > 0) {
                $jurnalEntries->push(['no_bukti' => $noBukti, 'tanggal' => $item->tanggal_pembayaran, 'akun' => 'Kas', 'debit' => $totalBayar, 'kredit' => 0, 'keterangan' => 'Pembayaran Angsuran']);
                if ($pokok > 0) $jurnalEntries->push(['no_bukti' => $noBukti, 'tanggal' => $item->tanggal_pembayaran, 'akun' => 'Piutang Pembiayaan', 'debit' => 0, 'kredit' => $pokok, 'keterangan' => 'Pembayaran Pokok']);
                if ($jasa > 0) $jurnalEntries->push(['no_bukti' => $noBukti, 'tanggal' => $item->tanggal_pembayaran, 'akun' => 'Pendapatan Jasa', 'debit' => 0, 'kredit' => $jasa, 'keterangan' => 'Pembayaran Jasa']);
            }
        }
    }

    $jurnalData = $jurnalEntries->groupBy('no_bukti')->sortByDesc(fn($group) => $group->first()['tanggal']);
    $totalDebit = $jurnalEntries->sum('debit');
    $totalKredit = $jurnalEntries->sum('kredit');
    // ----------------------------------------------------

    // Header untuk memaksa download sebagai Excel
    $headers = [
        'Content-Type' => 'application/vnd.ms-excel',
        'Content-Disposition' => 'attachment; filename="Jurnal_Umum_BMT_' . date('Y-m-d') . '.xls"',
        'Pragma' => 'no-cache',
    ];

    return response()->view('operator.laporan.export-excel', compact('jurnalData', 'totalDebit', 'totalKredit'))->withHeaders($headers);
}
}