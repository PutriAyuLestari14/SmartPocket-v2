<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotifikasiController extends Controller
{
    // Tampilkan semua notifikasi untuk nasabah yang login
    public function index()
    {
        $user = auth()->user();
        
        $notifikasis = Notifikasi::where('id_nasabah', $user->nasabah->id_nasabah)
            ->orderBy('tanggal_kirim', 'desc')
            ->paginate(10);

        // Hitung jumlah notifikasi belum dibaca
        $belumDibaca = Notifikasi::where('id_nasabah', $user->nasabah->id_nasabah)
            ->where('status', 'belum dibaca')
            ->count();

        return view('nasabah.notifikasi.index', compact('notifikasis', 'belumDibaca'));
    }

    // Tandai notifikasi sebagai sudah dibaca
    public function markAsRead($id)
    {
        $notifikasi = Notifikasi::findOrFail($id);
        
        // Pastikan notifikasi milik user yang login
        if ($notifikasi->id_nasabah !== auth()->user()->nasabah->id_nasabah) {
            abort(403);
        }

        $notifikasi->update(['status' => 'sudah dibaca']);

        return redirect()->back()->with('success', 'Notifikasi ditandai sebagai sudah dibaca');
    }

    // Tandai semua notifikasi sebagai sudah dibaca
    public function markAllAsRead()
    {
        $user = auth()->user();
        
        Notifikasi::where('id_nasabah', $user->nasabah->id_nasabah)
            ->where('status', 'belum dibaca')
            ->update(['status' => 'sudah dibaca']);

        return redirect()->back()->with('success', 'Semua notifikasi ditandai sebagai sudah dibaca');
    }

    // Fungsi untuk membuat notifikasi (dipanggil dari controller lain)
    public static function kirim($idNasabah, $judul, $pesan, $tipe = 'umum')
    {
        return Notifikasi::create([
            'id_nasabah' => $idNasabah,
            'judul' => $judul,
            'pesan' => $pesan,
            'tanggal_kirim' => now(),
            'status' => 'belum dibaca',
        ]);
    }
}