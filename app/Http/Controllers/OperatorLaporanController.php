<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Angsuran;
use Illuminate\Http\Request;

class OperatorLaporanController extends Controller
{
    public function index(Request $request)
    {
        $tanggalMulai = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_selesai;

        $peminjamans = Peminjaman::with('nasabah')
            ->where('status_verifikasi', 'disetujui')
            ->when($tanggalMulai, function ($query) use ($tanggalMulai) {
                $query->whereDate('tanggal_ajuan', '>=', $tanggalMulai);
            })
            ->when($tanggalSelesai, function ($query) use ($tanggalSelesai) {
                $query->whereDate('tanggal_ajuan', '<=', $tanggalSelesai);
            })
            ->orderBy('tanggal_ajuan', 'desc')
            ->get();

        $angsuran = Angsuran::with('peminjaman.nasabah')
            ->when($tanggalMulai, function ($query) use ($tanggalMulai) {
                $query->whereDate('tanggal_pembayaran', '>=', $tanggalMulai);
            })
            ->when($tanggalSelesai, function ($query) use ($tanggalSelesai) {
                $query->whereDate('tanggal_pembayaran', '<=', $tanggalSelesai);
            })
            ->orderBy('tanggal_pembayaran', 'desc')
            ->get();

        $jurnal = collect();

        // Jurnal pencairan pinjaman
        foreach ($peminjamans as $pinjaman) {
            $provisi = $pinjaman->jumlah_pinjaman * 0.01;
            $kasDiterima = $pinjaman->jumlah_pinjaman - $provisi;

            $jurnal->push([
                'tanggal' => $pinjaman->tanggal_ajuan,
                'keterangan' => 'Pencairan Pinjaman - ' . ($pinjaman->nasabah->nama ?? '-'),
                'debit' => 'Piutang Pinjaman',
                'kredit' => 'Kas',
                'nominal' => $kasDiterima,
            ]);

            $jurnal->push([
                'tanggal' => $pinjaman->tanggal_ajuan,
                'keterangan' => 'Provisi Pinjaman - ' . ($pinjaman->nasabah->nama ?? '-'),
                'debit' => 'Piutang Pinjaman',
                'kredit' => 'Pendapatan Provisi',
                'nominal' => $provisi,
            ]);
        }

        // Jurnal pembayaran angsuran
        foreach ($angsuran as $item) {
            $nama = $item->peminjaman->nasabah->nama ?? '-';

            if ($item->jumlah_pokok > 0) {
                $jurnal->push([
                    'tanggal' => $item->tanggal_pembayaran,
                    'keterangan' => 'Pembayaran Pokok - ' . $nama,
                    'debit' => 'Kas',
                    'kredit' => 'Piutang Pinjaman',
                    'nominal' => $item->jumlah_pokok,
                ]);
            }

            if ($item->jumlah_jasa > 0) {
                $jurnal->push([
                    'tanggal' => $item->tanggal_pembayaran,
                    'keterangan' => 'Pendapatan Jasa - ' . $nama,
                    'debit' => 'Kas',
                    'kredit' => 'Pendapatan Jasa',
                    'nominal' => $item->jumlah_jasa,
                ]);
            }
        }

        $jurnal = $jurnal->sortByDesc('tanggal')->values();

        return view('operator.laporan.index', compact(
            'jurnal',
            'tanggalMulai',
            'tanggalSelesai'
        ));
    }
}