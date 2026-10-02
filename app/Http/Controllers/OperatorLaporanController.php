<?php

namespace App\Http\Controllers;

use App\Models\DetailTabungan;
use App\Models\Peminjaman;
use App\Models\Angsuran;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class OperatorLaporanController extends Controller
{
    // tampilkan laporan jurnal umum
    public function index(Request $request)
    {
        // ambil filter dari request
        $tanggalMulai = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_akhir;
        $jenis = $request->jenis ?? 'semua';

        // tampung semua entri jurnal di collection
        $jurnalEntries = collect();

        // transaksi tabungan (setor & tarik)
        if ($jenis === 'semua' || $jenis === 'tabungan') {
            // ambil data dengan filter tanggal kalau ada
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

                // kalau setoran: kas masuk (debit), tabungan nasabah (kredit)
                if ((int) $item->id_jenis_transaksi === 1) {
                    $jurnalEntries->push([
                        'no_bukti' => $noBukti,
                        'tanggal' => $tanggal,
                        'akun' => 'Kas',
                        'debit' => $jumlah,
                        'kredit' => 0,
                        'keterangan' => $keterangan,
                    ]);
                    $jurnalEntries->push([
                        'no_bukti' => $noBukti,
                        'tanggal' => $tanggal,
                        'akun' => 'Tabungan Nasabah',
                        'debit' => 0,
                        'kredit' => $jumlah,
                        'keterangan' => $keterangan,
                    ]);
                } else {
                    // kalau penarikan: tabungan nasabah (debit), kas (kredit)
                    $jurnalEntries->push([
                        'no_bukti' => $noBukti,
                        'tanggal' => $tanggal,
                        'akun' => 'Tabungan Nasabah',
                        'debit' => $jumlah,
                        'kredit' => 0,
                        'keterangan' => $keterangan,
                    ]);
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

        // transaksi peminjaman (pencairan)
        if ($jenis === 'semua' || $jenis === 'peminjaman') {
            $peminjamans = Peminjaman::where('status_verifikasi', 'disetujui')
                ->when($tanggalMulai, fn($q) => $q->whereDate('tanggal_ajuan', '>=', $tanggalMulai))
                ->when($tanggalSelesai, fn($q) => $q->whereDate('tanggal_ajuan', '<=', $tanggalSelesai))
                ->orderBy('tanggal_ajuan', 'desc')
                ->get();

            foreach ($peminjamans as $pinjaman) {
                $noBukti = 'PIN-' . $pinjaman->id;
                $tanggal = $pinjaman->tanggal_ajuan;
                
                // hitung provisi 1% & kas yang keluar
                $jumlahPinjaman = (int) $pinjaman->jumlah_pinjaman;
                $provisi = (int) ($jumlahPinjaman * 0.01);
                $kasDiterima = $jumlahPinjaman - $provisi;

                // debit piutang (hak tagih penuh)
                $jurnalEntries->push([
                    'no_bukti' => $noBukti,
                    'tanggal' => $tanggal,
                    'akun' => 'Piutang Pembiayaan',
                    'debit' => $jumlahPinjaman,
                    'kredit' => 0,
                    'keterangan' => 'Pencairan Pinjaman',
                ]);

                // kredit pendapatan provisi
                $jurnalEntries->push([
                    'no_bukti' => $noBukti,
                    'tanggal' => $tanggal,
                    'akun' => 'Pendapatan Provisi',
                    'debit' => 0,
                    'kredit' => $provisi,
                    'keterangan' => 'Potongan Provisi',
                ]);

                // kredit kas (uang yang keluar aja)
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

        // transaksi angsuran (cicilan)
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
                    // debit kas (uang masuk)
                    $jurnalEntries->push([
                        'no_bukti' => $noBukti,
                        'tanggal' => $tanggal,
                        'akun' => 'Kas',
                        'debit' => $totalBayar,
                        'kredit' => 0,
                        'keterangan' => 'Pembayaran Angsuran',
                    ]);

                    // kredit piutang (kurangi hutang nasabah)
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

                    // kredit pendapatan jasa
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

        // kelompokkan per no_bukti, urut dari yang paling baru
        $jurnalData = $jurnalEntries
            ->groupBy('no_bukti')
            ->sortByDesc(function ($group) {
                return $group->first()['tanggal'];
            });

        // hitung total debit & kredit keseluruhan
        $totalDebit = $jurnalEntries->sum('debit');
        $totalKredit = $jurnalEntries->sum('kredit');

        // kirim ke view
        return view('operator.laporan.index', compact(
            'jurnalData',
            'tanggalMulai',
            'tanggalSelesai',
            'jenis',
            'totalDebit',
            'totalKredit'
        ));
    }

    // export jurnal ke excel
    public function export(Request $request)
    {
        // sama kayak index, tapi ini buat download excel
        $tanggalMulai = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_akhir;
        $jenis = $request->jenis ?? 'semua';

        $jurnalEntries = collect();

        // logika sama persis kayak index
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

        // header biar browser download sebagai excel
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="Jurnal_Umum_BMT_' . date('Y-m-d') . '.xls"',
            'Pragma' => 'no-cache',
        ];

        // kirim view export-excel + header download
        return response()->view('operator.laporan.export-excel', compact('jurnalData', 'totalDebit', 'totalKredit'))->withHeaders($headers);
    }
}