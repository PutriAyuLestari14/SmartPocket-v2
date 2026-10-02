<?php

namespace App\Http\Controllers;

use App\Models\DetailTabungan;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class OperatorNotifikasiController extends Controller
{
    public function index()
    {
        // Notifikasi dari penarikan pending
        $penarikanPending = DetailTabungan::with('rekening.nasabah')
            ->where('status', 'pending')
            ->where('id_jenis_transaksi', 2)
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        // Notifikasi dari pengajuan peminjaman pending
        $peminjamanPending = Peminjaman::with('nasabah')
            ->where('status_verifikasi', 'pending')
            ->orderBy('tanggal_ajuan', 'desc')
            ->get();

        // Total semua notifikasi pending
        $totalPending = $penarikanPending->count()
            + $peminjamanPending->count();

        return view('operator.notifikasi.index', compact(
            'penarikanPending',
            'peminjamanPending',
            'totalPending'
        ));
    }

    public function markAllAsRead()
    {
        return redirect()->back()
            ->with('success', 'Notifikasi dibaca');
    }
}