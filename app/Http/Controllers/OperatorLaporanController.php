<?php

namespace App\Http\Controllers;

use App\Models\DetailTabungan;
use App\Models\Peminjaman;
use App\Models\Angsuran;
use Illuminate\Http\Request;

class OperatorLaporanController extends Controller
{
    // Tampilkan laporan jurnal umum
    public function index(Request $request)
    {
        $tanggalMulai = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_akhir;
        $jenis = $request->jenis ?? 'semua';
        $jurnalEntries = collect();
        $waktuUrut = [];

        // ==================== TRANSAKSI TABUNGAN ====================
        if ($jenis === 'semua' || $jenis === 'tabungan') {
            $tabungans = DetailTabungan::with('rekening')
                ->where('status', 'berhasil')
                ->when($tanggalMulai, fn($q) =>
                    $q->whereDate('tanggal_transaksi', '>=', $tanggalMulai)
                )
                ->when($tanggalSelesai, fn($q) =>
                    $q->whereDate('tanggal_transaksi', '<=', $tanggalSelesai)
                )
                ->orderBy('tanggal_transaksi', 'desc')
                ->orderBy('created_at', 'desc')
                ->orderBy('id', 'desc')
                ->get();

            foreach ($tabungans as $item) {
                $tanggal = $item->tanggal_transaksi;
                $jumlah = (int) $item->jumlah;

                // Ambil langsung dari kolom detail_tabungan.no_rek
                $kodeRekening = $item->no_rek ?? '-';
                $keteranganAsli = strtolower(trim($item->keterangan ?? ''));

                $isPemindahanSaldo = str_contains(
                    $keteranganAsli,
                    'pemindahan saldo mengendap ke pendapatan usaha'
                );

                // Identifikasi transaksi biaya buku dan saldo awal
                $isBiayaBuku = str_contains($keteranganAsli, 'biaya buku tabungan')
                    || str_contains($keteranganAsli, 'pembayaran buku tabungan');

                $isSaldoAwal = str_contains($keteranganAsli, 'saldo awal');

                // Gunakan nomor kelompok yang sama jika rekening dan
                // waktu transaksi saldo awal/biaya buku sama persis.
                if ($isBiayaBuku || $isSaldoAwal) {
                    $waktuTransaksi = $tanggal
                        ? \Carbon\Carbon::parse($tanggal)->format('Y-m-d H:i:s')
                        : '';

                    $noBukti = 'TAB-GABUNG-' . $kodeRekening . '-' . $waktuTransaksi;
                } else {
                    $noBukti = 'TAB-' . $item->id;
                }

                // Simpan waktu input untuk pengurutan jurnal
                $waktuUrut[$noBukti] = $item->created_at
                    ? \Carbon\Carbon::parse($item->created_at)->format('H:i:s.u')
                    : '00:00:00.000000';

                // Tentukan keterangan transaksi
                if (str_contains($keteranganAsli, 'bagi hasil')) {
                    $keterangan = $item->keterangan;
                } elseif ($isBiayaBuku) {
                    $keterangan = 'Pembayaran Buku Tabungan';
                } elseif ($isSaldoAwal) {
                    $keterangan = 'Setoran Tabungan';
                } elseif ((int) $item->id_jenis_transaksi === 1) {
                    $keterangan = 'Setoran Tabungan';
                } else {
                    $keterangan = 'Penarikan Tabungan';
                }

                // Biaya buku dicatat terpisah:
                // Debit Kas dan Kredit Pendapatan Lain-lain.
                // Tidak masuk lagi ke Tabungan Nasabah.
                if ($isBiayaBuku) {
                    $jurnalEntries->push([
                        'no_bukti' => $noBukti,
                        'tanggal' => $tanggal,
                        'no_rekening' => $kodeRekening,
                        'akun' => 'Kas',
                        'debit' => $jumlah,
                        'kredit' => 0,
                        'keterangan' => $keterangan,
                    ]);

                    $jurnalEntries->push([
                        'no_bukti' => $noBukti,
                        'tanggal' => $tanggal,
                        'no_rekening' => $kodeRekening,
                        'akun' => 'Pendapatan Lain-lain',
                        'debit' => 0,
                        'kredit' => $jumlah,
                        'keterangan' => $keterangan,
                    ]);

                    continue;
                }

                // Pemindahan saldo mengendap ke Pendapatan Usaha
                if ($isPemindahanSaldo) {
                    $keterangan = 'Pemindahan Saldo Mengendap ke Pendapatan Usaha';

                    // Debit Tabungan Nasabah
                    $jurnalEntries->push([
                        'no_bukti' => $noBukti,
                        'tanggal' => $tanggal,
                        'no_rekening' => $kodeRekening,
                        'akun' => 'Tabungan Nasabah',
                        'debit' => $jumlah,
                        'kredit' => 0,
                        'keterangan' => $keterangan,
                    ]);

                    // Kredit Pendapatan Usaha
                    $jurnalEntries->push([
                        'no_bukti' => $noBukti,
                        'tanggal' => $tanggal,
                        'no_rekening' => $kodeRekening,
                        'akun' => 'Pendapatan Usaha',
                        'debit' => 0,
                        'kredit' => $jumlah,
                        'keterangan' => $keterangan,
                    ]);

                    continue;
                }

                if ((int) $item->id_jenis_transaksi === 1) {
                    // Debit Kas
                    $jurnalEntries->push([
                        'no_bukti' => $noBukti,
                        'tanggal' => $tanggal,
                        'no_rekening' => $kodeRekening,
                        'akun' => 'Kas',
                        'debit' => $jumlah,
                        'kredit' => 0,
                        'keterangan' => $keterangan,
                    ]);

                    // Kredit Tabungan Nasabah
                    $jurnalEntries->push([
                        'no_bukti' => $noBukti,
                        'tanggal' => $tanggal,
                        'no_rekening' => $kodeRekening,
                        'akun' => 'Tabungan Nasabah',
                        'debit' => 0,
                        'kredit' => $jumlah,
                        'keterangan' => $keterangan,
                    ]);
                } else {
                    // Debit Tabungan Nasabah
                    $jurnalEntries->push([
                        'no_bukti' => $noBukti,
                        'tanggal' => $tanggal,
                        'no_rekening' => $kodeRekening,
                        'akun' => 'Tabungan Nasabah',
                        'debit' => $jumlah,
                        'kredit' => 0,
                        'keterangan' => $keterangan,
                    ]);

                    // Kredit Kas
                    $jurnalEntries->push([
                        'no_bukti' => $noBukti,
                        'tanggal' => $tanggal,
                        'no_rekening' => $kodeRekening,
                        'akun' => 'Kas',
                        'debit' => 0,
                        'kredit' => $jumlah,
                        'keterangan' => $keterangan,
                    ]);
                }
            }
        }

        // ==================== TRANSAKSI PEMINJAMAN ====================
        if ($jenis === 'semua' || $jenis === 'peminjaman') {
            $peminjamans = Peminjaman::with(['nasabah.rekening'])
                ->where('status_verifikasi', 'disetujui')
                ->when($tanggalMulai, fn($q) => $q->whereDate('tanggal_ajuan', '>=', $tanggalMulai))
                ->when($tanggalSelesai, fn($q) => $q->whereDate('tanggal_ajuan', '<=', $tanggalSelesai))
                ->orderBy('tanggal_ajuan', 'desc')
                ->orderBy('created_at', 'desc')
                ->orderBy('id_pinjaman', 'desc')
                ->get();

            foreach ($peminjamans as $pinjaman) {
                $noBukti = 'PIN-' . $pinjaman->id_pinjaman;
                $tanggal = $pinjaman->tanggal_ajuan;

                // Simpan waktu input untuk pengurutan jurnal
                $waktuUrut[$noBukti] = $pinjaman->created_at
                    ? \Carbon\Carbon::parse($pinjaman->created_at)->format('H:i:s.u')
                    : '00:00:00.000000';

                $kodeRekening = $pinjaman->nasabah?->rekening?->no_rek
                    ?? $pinjaman->nasabah?->no_rek
                    ?? '-';

                $keteranganPinjaman = 'Pencairan Pinjaman';
                $keteranganProvisi = 'Potongan Provisi';

                $jumlahPinjaman = (int) $pinjaman->jumlah_pinjaman;
                $provisi = (int) ($jumlahPinjaman * 0.01);
                $kasDiterima = $jumlahPinjaman - $provisi;

                // Debit Piutang Pembiayaan
                $jurnalEntries->push([
                    'no_bukti' => $noBukti,
                    'tanggal' => $tanggal,
                    'no_rekening' => $kodeRekening,
                    'akun' => 'Piutang Pembiayaan',
                    'debit' => $jumlahPinjaman,
                    'kredit' => 0,
                    'keterangan' => $keteranganPinjaman,
                ]);

                // Kredit Pendapatan Provisi
                $jurnalEntries->push([
                    'no_bukti' => $noBukti,
                    'tanggal' => $tanggal,
                    'no_rekening' => $kodeRekening,
                    'akun' => 'Pendapatan Provisi',
                    'debit' => 0,
                    'kredit' => $provisi,
                    'keterangan' => $keteranganProvisi,
                ]);

                // Kredit Kas
                $jurnalEntries->push([
                    'no_bukti' => $noBukti,
                    'tanggal' => $tanggal,
                    'no_rekening' => $kodeRekening,
                    'akun' => 'Kas',
                    'debit' => 0,
                    'kredit' => $kasDiterima,
                    'keterangan' => $keteranganPinjaman,
                ]);
            }
        }

        // ==================== TRANSAKSI ANGSURAN ====================
        if ($jenis === 'semua' || $jenis === 'peminjaman' || $jenis === 'jasa') {
            $angsurans = Angsuran::with(['peminjaman.nasabah.rekening'])
                ->when($tanggalMulai, fn($q) => $q->whereDate('tanggal_pembayaran', '>=', $tanggalMulai))
                ->when($tanggalSelesai, fn($q) => $q->whereDate('tanggal_pembayaran', '<=', $tanggalSelesai))
                ->orderBy('tanggal_pembayaran', 'desc')
                ->orderBy('created_at', 'desc')
                ->orderBy('id_pembayaran', 'desc')
                ->get();

            foreach ($angsurans as $item) {
                $noBukti = 'ANG-' . $item->id_pembayaran;
                $tanggal = $item->tanggal_pembayaran;

                // Simpan waktu input untuk pengurutan jurnal
                $waktuUrut[$noBukti] = $item->created_at
                    ? \Carbon\Carbon::parse($item->created_at)->format('H:i:s.u')
                    : '00:00:00.000000';

                $kodeRekening = $item->peminjaman?->nasabah?->rekening?->no_rek
                    ?? $item->peminjaman?->nasabah?->no_rek
                    ?? '-';

                $keteranganAngsuran = 'Pembayaran Angsuran';
                $keteranganPokok = 'Pembayaran Pokok';
                $keteranganJasa = 'Pembayaran Jasa';

                $pokok = (int) $item->jumlah_pokok;
                $jasa = (int) $item->jumlah_jasa;
                $totalBayar = $pokok + $jasa;

                if ($totalBayar <= 0) {
                    continue;
                }

                // Debit Kas
                $jurnalEntries->push([
                    'no_bukti' => $noBukti,
                    'tanggal' => $tanggal,
                    'no_rekening' => $kodeRekening,
                    'akun' => 'Kas',
                    'debit' => $totalBayar,
                    'kredit' => 0,
                    'keterangan' => $keteranganAngsuran,
                ]);

                // Kredit Piutang Pembiayaan
                if ($pokok > 0) {
                    $jurnalEntries->push([
                        'no_bukti' => $noBukti,
                        'tanggal' => $tanggal,
                        'no_rekening' => $kodeRekening,
                        'akun' => 'Piutang Pembiayaan',
                        'debit' => 0,
                        'kredit' => $pokok,
                        'keterangan' => $keteranganPokok,
                    ]);
                }

                // Kredit Pendapatan Jasa
                if ($jasa > 0) {
                    $jurnalEntries->push([
                        'no_bukti' => $noBukti,
                        'tanggal' => $tanggal,
                        'no_rekening' => $kodeRekening,
                        'akun' => 'Pendapatan Usaha',
                        'debit' => 0,
                        'kredit' => $jasa,
                        'keterangan' => $keteranganJasa,
                    ]);
                }
            }
        }

        // ==================== KELOMPOKKAN JURNAL ====================
        $jurnalData = $jurnalEntries
            ->groupBy('no_bukti')
            ->sortByDesc(function ($group) use ($waktuUrut) {
                $entry = $group->first();

                $tanggal = $entry['tanggal']
                    ? \Carbon\Carbon::parse($entry['tanggal'])->format('Y-m-d')
                    : '0000-00-00';

                $waktu = $waktuUrut[$entry['no_bukti']]
                    ?? '00:00:00.000000';

                return $tanggal . ' ' . $waktu;
            })
            ->values();

        $totalDebit = $jurnalEntries->sum('debit');
        $totalKredit = $jurnalEntries->sum('kredit');

        return view('operator.laporan.index', compact(
            'jurnalData',
            'tanggalMulai',
            'tanggalSelesai',
            'jenis',
            'totalDebit',
            'totalKredit'
        ));
    }

    // ==================== EXPORT JURNAL KE EXCEL ====================
    public function export(Request $request)
    {
        $tanggalMulai = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_akhir;
        $jenis = $request->jenis ?? 'semua';
        $jurnalEntries = collect();
        $waktuUrut = [];

        // ==================== TRANSAKSI TABUNGAN ====================
        if ($jenis === 'semua' || $jenis === 'tabungan') {
            $tabungans = DetailTabungan::with('rekening')
                ->where('status', 'berhasil')
                ->when($tanggalMulai, fn($q) =>
                    $q->whereDate('tanggal_transaksi', '>=', $tanggalMulai)
                )
                ->when($tanggalSelesai, fn($q) =>
                    $q->whereDate('tanggal_transaksi', '<=', $tanggalSelesai)
                )
                ->orderBy('tanggal_transaksi', 'desc')
                ->orderBy('created_at', 'desc')
                ->orderBy('id', 'desc')
                ->get();

            foreach ($tabungans as $item) {
                $tanggal = $item->tanggal_transaksi;
                $jumlah = (int) $item->jumlah;

                // Ambil langsung dari kolom detail_tabungan.no_rek
                $kodeRekening = $item->no_rek ?? '-';
                $keteranganAsli = strtolower(trim($item->keterangan ?? ''));

                $isPemindahanSaldo = str_contains(
                    $keteranganAsli,
                    'pemindahan saldo mengendap ke pendapatan usaha'
                );

                // Identifikasi transaksi biaya buku dan saldo awal
                $isBiayaBuku = str_contains($keteranganAsli, 'biaya buku tabungan')
                    || str_contains($keteranganAsli, 'pembayaran buku tabungan');

                $isSaldoAwal = str_contains($keteranganAsli, 'saldo awal');

                // Gunakan nomor kelompok yang sama jika rekening dan
                // waktu transaksi saldo awal/biaya buku sama persis.
                if ($isBiayaBuku || $isSaldoAwal) {
                    $waktuTransaksi = $tanggal
                        ? \Carbon\Carbon::parse($tanggal)->format('Y-m-d H:i:s')
                        : '';

                    $noBukti = 'TAB-GABUNG-' . $kodeRekening . '-' . $waktuTransaksi;
                } else {
                    $noBukti = 'TAB-' . $item->id;
                }

                // Simpan waktu input untuk pengurutan jurnal
                $waktuUrut[$noBukti] = $item->created_at
                    ? \Carbon\Carbon::parse($item->created_at)->format('H:i:s.u')
                    : '00:00:00.000000';

                if (str_contains($keteranganAsli, 'bagi hasil')) {
                    $ket = $item->keterangan;
                } elseif ($isBiayaBuku) {
                    $ket = 'Pembayaran Buku Tabungan';
                } elseif ($isSaldoAwal) {
                    $ket = 'Setoran Tabungan';
                } elseif ((int) $item->id_jenis_transaksi === 1) {
                    $ket = 'Setoran Tabungan';
                } else {
                    $ket = 'Penarikan Tabungan';
                }

                // Biaya buku hanya dicatat ke Kas dan Pendapatan Lain-lain.
                if ($isBiayaBuku) {
                    $jurnalEntries->push([
                        'no_bukti' => $noBukti,
                        'tanggal' => $tanggal,
                        'no_rekening' => $kodeRekening,
                        'akun' => 'Kas',
                        'debit' => $jumlah,
                        'kredit' => 0,
                        'keterangan' => $ket,
                    ]);

                    $jurnalEntries->push([
                        'no_bukti' => $noBukti,
                        'tanggal' => $tanggal,
                        'no_rekening' => $kodeRekening,
                        'akun' => 'Pendapatan Lain-lain',
                        'debit' => 0,
                        'kredit' => $jumlah,
                        'keterangan' => $ket,
                    ]);

                    continue;
                }

                // Pemindahan saldo mengendap ke Pendapatan Usaha
                if ($isPemindahanSaldo) {
                    $ket = 'Pemindahan Saldo Mengendap ke Pendapatan Usaha';

                    $jurnalEntries->push([
                        'no_bukti' => $noBukti,
                        'tanggal' => $tanggal,
                        'no_rekening' => $kodeRekening,
                        'akun' => 'Tabungan Nasabah',
                        'debit' => $jumlah,
                        'kredit' => 0,
                        'keterangan' => $ket,
                    ]);

                    $jurnalEntries->push([
                        'no_bukti' => $noBukti,
                        'tanggal' => $tanggal,
                        'no_rekening' => $kodeRekening,
                        'akun' => 'Pendapatan Usaha',
                        'debit' => 0,
                        'kredit' => $jumlah,
                        'keterangan' => $ket,
                    ]);

                    continue;
                }

                if ((int) $item->id_jenis_transaksi === 1) {
                    $jurnalEntries->push([
                        'no_bukti' => $noBukti,
                        'tanggal' => $tanggal,
                        'no_rekening' => $kodeRekening,
                        'akun' => 'Kas',
                        'debit' => $jumlah,
                        'kredit' => 0,
                        'keterangan' => $ket,
                    ]);

                    $jurnalEntries->push([
                        'no_bukti' => $noBukti,
                        'tanggal' => $tanggal,
                        'no_rekening' => $kodeRekening,
                        'akun' => 'Tabungan Nasabah',
                        'debit' => 0,
                        'kredit' => $jumlah,
                        'keterangan' => $ket,
                    ]);
                } else {
                    $jurnalEntries->push([
                        'no_bukti' => $noBukti,
                        'tanggal' => $tanggal,
                        'no_rekening' => $kodeRekening,
                        'akun' => 'Tabungan Nasabah',
                        'debit' => $jumlah,
                        'kredit' => 0,
                        'keterangan' => $ket,
                    ]);

                    $jurnalEntries->push([
                        'no_bukti' => $noBukti,
                        'tanggal' => $tanggal,
                        'no_rekening' => $kodeRekening,
                        'akun' => 'Kas',
                        'debit' => 0,
                        'kredit' => $jumlah,
                        'keterangan' => $ket,
                    ]);
                }
            }
        }

        // ==================== TRANSAKSI PEMINJAMAN ====================
        if ($jenis === 'semua' || $jenis === 'peminjaman') {
            $peminjamans = Peminjaman::with(['nasabah.rekening'])
                ->where('status_verifikasi', 'disetujui')
                ->when($tanggalMulai, fn($q) => $q->whereDate('tanggal_ajuan', '>=', $tanggalMulai))
                ->when($tanggalSelesai, fn($q) => $q->whereDate('tanggal_ajuan', '<=', $tanggalSelesai))
                ->orderBy('tanggal_ajuan', 'desc')
                ->orderBy('created_at', 'desc')
                ->orderBy('id_pinjaman', 'desc')
                ->get();

            foreach ($peminjamans as $pinjaman) {
                $noBukti = 'PIN-' . $pinjaman->id_pinjaman;
                $tanggal = $pinjaman->tanggal_ajuan;

                // Simpan waktu input untuk pengurutan jurnal
                $waktuUrut[$noBukti] = $pinjaman->created_at
                    ? \Carbon\Carbon::parse($pinjaman->created_at)->format('H:i:s.u')
                    : '00:00:00.000000';

                $kodeRekening = $pinjaman->nasabah?->rekening?->no_rek
                    ?? $pinjaman->nasabah?->no_rek
                    ?? '-';

                $keteranganPinjaman = 'Pencairan Pinjaman';
                $keteranganProvisi = 'Potongan Provisi';

                $jumlahPinjaman = (int) $pinjaman->jumlah_pinjaman;
                $provisi = (int) ($jumlahPinjaman * 0.01);
                $kasDiterima = $jumlahPinjaman - $provisi;

                $jurnalEntries->push([
                    'no_bukti' => $noBukti,
                    'tanggal' => $tanggal,
                    'no_rekening' => $kodeRekening,
                    'akun' => 'Piutang Pembiayaan',
                    'debit' => $jumlahPinjaman,
                    'kredit' => 0,
                    'keterangan' => $keteranganPinjaman,
                ]);

                $jurnalEntries->push([
                    'no_bukti' => $noBukti,
                    'tanggal' => $tanggal,
                    'no_rekening' => $kodeRekening,
                    'akun' => 'Pendapatan Provisi',
                    'debit' => 0,
                    'kredit' => $provisi,
                    'keterangan' => $keteranganProvisi,
                ]);

                $jurnalEntries->push([
                    'no_bukti' => $noBukti,
                    'tanggal' => $tanggal,
                    'no_rekening' => $kodeRekening,
                    'akun' => 'Kas',
                    'debit' => 0,
                    'kredit' => $kasDiterima,
                    'keterangan' => $keteranganPinjaman,
                ]);
            }
        }

        // ==================== TRANSAKSI ANGSURAN ====================
        if ($jenis === 'semua' || $jenis === 'peminjaman' || $jenis === 'jasa') {
            $angsurans = Angsuran::with(['peminjaman.nasabah.rekening'])
                ->when($tanggalMulai, fn($q) => $q->whereDate('tanggal_pembayaran', '>=', $tanggalMulai))
                ->when($tanggalSelesai, fn($q) => $q->whereDate('tanggal_pembayaran', '<=', $tanggalSelesai))
                ->orderBy('tanggal_pembayaran', 'desc')
                ->orderBy('created_at', 'desc')
                ->orderBy('id_pembayaran', 'desc')
                ->get();

            foreach ($angsurans as $item) {
                $noBukti = 'ANG-' . $item->id_pembayaran;
                $tanggal = $item->tanggal_pembayaran;

                // Simpan waktu input untuk pengurutan jurnal
                $waktuUrut[$noBukti] = $item->created_at
                    ? \Carbon\Carbon::parse($item->created_at)->format('H:i:s.u')
                    : '00:00:00.000000';

                $kodeRekening = $item->peminjaman?->nasabah?->rekening?->no_rek
                    ?? $item->peminjaman?->nasabah?->no_rek
                    ?? '-';

                $keteranganAngsuran = 'Pembayaran Angsuran';
                $keteranganPokok = 'Pembayaran Pokok';
                $keteranganJasa = 'Pembayaran Jasa';

                $pokok = (int) $item->jumlah_pokok;
                $jasa = (int) $item->jumlah_jasa;
                $totalBayar = $pokok + $jasa;

                if ($totalBayar <= 0) {
                    continue;
                }

                $jurnalEntries->push([
                    'no_bukti' => $noBukti,
                    'tanggal' => $tanggal,
                    'no_rekening' => $kodeRekening,
                    'akun' => 'Kas',
                    'debit' => $totalBayar,
                    'kredit' => 0,
                    'keterangan' => $keteranganAngsuran,
                ]);

                if ($pokok > 0) {
                    $jurnalEntries->push([
                        'no_bukti' => $noBukti,
                        'tanggal' => $tanggal,
                        'no_rekening' => $kodeRekening,
                        'akun' => 'Piutang Pembiayaan',
                        'debit' => 0,
                        'kredit' => $pokok,
                        'keterangan' => $keteranganPokok,
                    ]);
                }

                if ($jasa > 0) {
                    $jurnalEntries->push([
                        'no_bukti' => $noBukti,
                        'tanggal' => $tanggal,
                        'no_rekening' => $kodeRekening,
                        'akun' => 'Pendapatan Usaha',
                        'debit' => 0,
                        'kredit' => $jasa,
                        'keterangan' => $keteranganJasa,
                    ]);
                }
            }
        }

        // ==================== SIAPKAN DATA EXPORT ====================
        $jurnalData = $jurnalEntries
            ->groupBy('no_bukti')
            ->sortByDesc(function ($group) use ($waktuUrut) {
                $entry = $group->first();

                $tanggal = $entry['tanggal']
                    ? \Carbon\Carbon::parse($entry['tanggal'])->format('Y-m-d')
                    : '0000-00-00';

                $waktu = $waktuUrut[$entry['no_bukti']]
                    ?? '00:00:00.000000';

                return $tanggal . ' ' . $waktu;
            })
            ->values();

        $totalDebit = $jurnalEntries->sum('debit');
        $totalKredit = $jurnalEntries->sum('kredit');

        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="Jurnal_Umum_BMT_' . date('Y-m-d') . '.xls"',
            'Pragma' => 'no-cache',
        ];

        return response()
            ->view('operator.laporan.export-excel', compact(
                'jurnalData',
                'totalDebit',
                'totalKredit'
            ))
            ->withHeaders($headers);
    }
}
