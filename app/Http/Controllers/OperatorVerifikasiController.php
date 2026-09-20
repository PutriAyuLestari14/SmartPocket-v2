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
    public function index()
    {
        // Ambil data pending dengan pagination
        $pengajuan = DetailTabungan::with(['rekening.nasabah.user'])
            ->where('id_jenis_transaksi', 2) 
            ->where('status', 'pending')
            ->orderBy('tanggal_transaksi', 'desc')
            ->paginate(10);

        // Hitung buat sidebar kanan
        $pendingCount = DetailTabungan::where('id_jenis_transaksi', 2)
            ->where('status', 'pending')
            ->count();
            
        $approvedToday = DetailTabungan::where('id_jenis_transaksi', 2)
            ->where('status', 'berhasil')
            ->whereDate('tanggal_transaksi', today())
            ->count();

        $rejectedToday = DetailTabungan::where('id_jenis_transaksi', 2)
            ->where('status', 'gagal')
            ->whereDate('tanggal_transaksi', today())
            ->count();

        return view('operator.verifikasi.index', compact('pengajuan', 'pendingCount', 'approvedToday', 'rejectedToday'));
    }

    public function approve($id)
    {
        $trx = DetailTabungan::findOrFail($id);
        $rekening = RekeningTabungan::where('no_rek', $trx->no_rek)->first();

        if (!$rekening) {
            return back()->with('error', 'Data rekening tidak ditemukan.');
        }

        DB::beginTransaction();
        try {
            if ($rekening->saldo < $trx->jumlah) {
                return back()->with('error', 'Gagal: Saldo nasabah tidak mencukupi.');
            }

            // Kurangi saldo
            $rekening->saldo -= $trx->jumlah;
            $rekening->save();

            // Update status & catat petugas yang approve
            $trx->status = 'berhasil';
            $trx->id_petugas = auth()->user()->petugas->id_petugas;
            $trx->save();

            // Kirim notifikasi ke nasabah
            $nasabah = $rekening->nasabah;
            NotifikasiController::kirim(
                $nasabah->id_nasabah,
                'Penarikan Disetujui ✅',
                'Pengajuan penarikan dana sebesar Rp ' . number_format($trx->jumlah, 0, ',', '.') . ' telah disetujui. Saldo Anda telah dikurangi.',
                'penarikan'
            );

            DB::commit();
            
            $namaNasabah = $rekening->nasabah->nama ?? 'Nasabah';
            return back()->with('success', 'Penarikan a.n ' . $namaNasabah . ' berhasil disetujui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function reject($id)
    {
        $trx = DetailTabungan::findOrFail($id);
        $rekening = RekeningTabungan::where('no_rek', $trx->no_rek)->first();
        $namaNasabah = $rekening ? ($rekening->nasabah->nama ?? 'Nasabah') : 'Nasabah';

        DB::beginTransaction();
        try {
            // Ubah status menjadi ditolak/gagal (Saldo GAK berubah)
            $trx->status = 'gagal'; 
            $trx->id_petugas = auth()->user()->petugas->id_petugas;
            $trx->save();

            // Kirim notifikasi ke nasabah
            $nasabah = $rekening->nasabah;
            NotifikasiController::kirim(
                $nasabah->id_nasabah,
                'Penarikan Ditolak ❌',
                'Pengajuan penarikan dana sebesar Rp ' . number_format($trx->jumlah, 0, ',', '.') . ' telah ditolak oleh operator.',
                'penarikan'
            );

            DB::commit();
            return back()->with('success', 'Pengajuan penarikan a.n ' . $namaNasabah . ' telah ditolak.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses: ' . $e->getMessage());
        }
    }
}