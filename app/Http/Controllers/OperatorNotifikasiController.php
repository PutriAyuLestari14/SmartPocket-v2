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
            ->where('id_jenis_transaksi', 2) // Penarikan
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        // Notifikasi dari peminjaman pending (kalau ada)
        // $peminjamanPending = Peminjaman::with('nasabah')
        //     ->where('status', 'pending')
        //     ->orderBy('tanggal_pengajuan', 'desc')
        //     ->get();

        $totalPending = $penarikanPending->count();

        return view('operator.notifikasi.index', compact('penarikanPending', 'totalPending'));
    }

    public function markAllAsRead()
    {
        // Reset badge dengan mengubah status (opsional)
        return redirect()->back()->with('success', 'Notifikasi dibaca');
    }
}