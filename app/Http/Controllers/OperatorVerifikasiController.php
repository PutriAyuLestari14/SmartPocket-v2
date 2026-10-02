<?php

namespace App\Http\Controllers;

use App\Models\DetailTabungan;
use App\Models\RekeningTabungan;
use Illuminate\Http\Request;
use App\Http\Controllers\NotifikasiController;
use App\Models\Nasabah;
use Illuminate\Support\Facades\DB;

class OperatorVerifikasiController extends Controller
{
    // tampilkan halaman verifikasi penarikan
    public function index()
    {
        // ambil pengajuan penarikan (jenis=2) yang masih pending
        // urut dari yang paling baru, paginate 10 per halaman
        $pengajuan = DetailTabungan::with(['rekening.nasabah.user'])
            ->where('id_jenis_transaksi', 2) 
            ->where('status', 'pending')
            ->orderBy('tanggal_transaksi', 'desc')
            ->paginate(10);

        // hitung total pending buat badge di tab
        $pendingCount = DetailTabungan::where('id_jenis_transaksi', 2)
            ->where('status', 'pending')
            ->count();
        
        // hitung yang disetujui hari ini
        $approvedToday = DetailTabungan::where('id_jenis_transaksi', 2)
            ->where('status', 'berhasil')
            ->whereDate('tanggal_transaksi', today())
            ->count();

        // hitung yang ditolak hari ini
        $rejectedToday = DetailTabungan::where('id_jenis_transaksi', 2)
            ->where('status', 'gagal')
            ->whereDate('tanggal_transaksi', today())
            ->count();

        // kirim ke view
        return view('operator.verifikasi.index', compact('pengajuan', 'pendingCount', 'approvedToday', 'rejectedToday'));
    }

    // setujui pengajuan penarikan
    public function approve($id)
    {
        // cari transaksi yang mau di-approve
        $trx = DetailTabungan::findOrFail($id);

        // cari rekening nasabahnya
        $rekening = RekeningTabungan::where('no_rek', $trx->no_rek)->first();

        // kalau rekening gak ada, tolak
        if (!$rekening) {
            return back()->with('error', 'Data rekening tidak ditemukan.');
        }

        // mulai transaksi
        DB::beginTransaction();
        try {
            // kalau saldo kurang dari yang diminta, batalkan
            if ($rekening->saldo < $trx->jumlah) {
                return back()->with('error', 'Gagal: Saldo nasabah tidak mencukupi.');
            }

            // kurangi saldo nasabah
            $rekening->saldo -= $trx->jumlah;
            $rekening->save();

            // update status jadi berhasil + catat petugasnya
            $trx->status = 'berhasil';
            $trx->id_petugas = auth()->user()->petugas->id_petugas;
            $trx->save();

            // kirim notifikasi ke nasabah kalau penarikan disetujui
            $nasabah = $rekening->nasabah;
            NotifikasiController::kirim(
                $nasabah->id_nasabah,
                'Penarikan Disetujui ✅',
                'Pengajuan penarikan dana sebesar Rp ' . number_format($trx->jumlah, 0, ',', '.') . ' telah disetujui. Saldo Anda telah dikurangi.',
                'penarikan'
            );

            // simpan permanen
            DB::commit();
            
            // balikin dengan pesan sukses
            $namaNasabah = $rekening->nasabah->nama ?? 'Nasabah';
            return back()->with('success', 'Penarikan a.n ' . $namaNasabah . ' berhasil disetujui!');

        } catch (\Exception $e) {
            // kalau error, batalkan semua
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    // tolak pengajuan penarikan
    public function reject($id)
    {
        // cari transaksi yang mau ditolak
        $trx = DetailTabungan::findOrFail($id);

        // cari rekening buat ambil nama nasabah
        $rekening = RekeningTabungan::where('no_rek', $trx->no_rek)->first();
        $namaNasabah = $rekening ? ($rekening->nasabah->nama ?? 'Nasabah') : 'Nasabah';

        // mulai transaksi
        DB::beginTransaction();
        try {
            // ubah status jadi gagal/ditolak
            // saldo gak berubah karena penarikan ditolak
            $trx->status = 'gagal'; 
            $trx->id_petugas = auth()->user()->petugas->id_petugas;
            $trx->save();

            // kirim notifikasi ke nasabah kalau penarikan ditolak
            $nasabah = $rekening->nasabah;
            NotifikasiController::kirim(
                $nasabah->id_nasabah,
                'Penarikan Ditolak ❌',
                'Pengajuan penarikan dana sebesar Rp ' . number_format($trx->jumlah, 0, ',', '.') . ' telah ditolak oleh operator.',
                'penarikan'
            );

            // simpan permanen
            DB::commit();

            // balikin dengan pesan sukses
            return back()->with('success', 'Pengajuan penarikan a.n ' . $namaNasabah . ' telah ditolak.');

        } catch (\Exception $e) {
            // kalau error, batalkan semua
            DB::rollBack();
            return back()->with('error', 'Gagal memproses: ' . $e->getMessage());
        }
    }
}