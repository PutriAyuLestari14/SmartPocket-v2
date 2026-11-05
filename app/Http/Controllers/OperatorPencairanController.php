<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OperatorPencairanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with('nasabah')
            ->where('status_verifikasi', 'disetujui')
            ->orderBy('tanggal_ajuan', 'desc')
            ->get();

        $totalMenunggu = $peminjaman->count();

        $totalNominal = $peminjaman->sum('jumlah_pinjaman');

        $sudahDicairkan = Peminjaman::where(
            'status_verifikasi',
            'aktif'
        )->count();

        return view('operator.pencairan.index', compact(
            'peminjaman',
            'totalMenunggu',
            'totalNominal',
            'sudahDicairkan'
        ));
    }

    public function cairkan($id)
    {
        $pinjaman = Peminjaman::findOrFail($id);

        if ($pinjaman->status_verifikasi !== 'disetujui') {
            return redirect()
                ->route('operator.pencairan.index')
                ->with('error', 'Pinjaman ini tidak dapat dicairkan.');
        }

        DB::transaction(function () use ($pinjaman) {
            $pinjaman = Peminjaman::where(
                'id_pinjaman',
                $pinjaman->id_pinjaman
            )->lockForUpdate()->firstOrFail();

            if ($pinjaman->status_verifikasi !== 'disetujui') {
                throw new \RuntimeException(
                    'Status pinjaman sudah berubah atau telah dicairkan.'
                );
            }

            $pinjaman->status_verifikasi = 'aktif';
            $pinjaman->id_petugas = auth()->id();
            $pinjaman->save();
        });

        return redirect()
            ->route('operator.pencairan.index')
            ->with('success', 'Pinjaman berhasil dicairkan.');
    }
}
