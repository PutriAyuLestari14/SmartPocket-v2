<?php

namespace App\Http\Controllers;

use App\Models\DetailTabungan;
use App\Models\RekeningTabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OperatorVerifikasiController extends Controller
{
    public function index()
    {
        // Ambil data pending dengan pagination
        // id_jenis_transaksi = 2 diasumsiin buat Penarikan 
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
            $trx->id_petugas = auth()->id(); 
            $trx->save();

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
            $trx->id_petugas = auth()->id(); 
            $trx->save();

            DB::commit();
            return back()->with('success', 'Pengajuan penarikan a.n ' . $namaNasabah . ' telah ditolak.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses: ' . $e->getMessage());
        }
    }
}