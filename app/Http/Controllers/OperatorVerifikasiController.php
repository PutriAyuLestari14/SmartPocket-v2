<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\RekeningTabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OperatorVerifikasiController extends Controller
{
    public function index()
    {
        // Ambil data pending dengan pagination
        $pengajuan = Transaksi::with(['user.nasabah'])
            ->where('jenis', 'penarikan')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Hitung statistik untuk sidebar kanan
        $pendingCount = Transaksi::where('jenis', 'penarikan')->where('status', 'pending')->count();
        $approvedToday = Transaksi::where('jenis', 'penarikan')->where('status', 'berhasil')->whereDate('created_at', today())->count();
        $rejectedToday = Transaksi::where('jenis', 'penarikan')->where('status', 'ditolak')->whereDate('created_at', today())->count();

        return view('operator.verifikasi.index', compact('pengajuan', 'pendingCount', 'approvedToday', 'rejectedToday'));
    }

    public function approve($id)
    {
        $trx = Transaksi::findOrFail($id);
        $rekening = RekeningTabungan::where('id_nasabah', $trx->user->nasabah->id_nasabah)->first();

        DB::beginTransaction();
        try {
            if ($rekening->saldo < $trx->jumlah) {
                return back()->with('error', 'Gagal: Saldo nasabah tidak mencukupi saat ini.');
            }

            // 1. Kurangi Saldo
            $rekening->saldo -= $trx->jumlah;
            $rekening->save();

            // 2. Ubah Status menjadi Berhasil
            $trx->status = 'berhasil';
            $trx->operator_id = auth()->id();
            $trx->save();

            DB::commit();
            return back()->with('success', 'Penarikan a.n ' . $trx->user->nasabah->nama . ' sebesar Rp ' . number_format($trx->jumlah, 0, ',', '.') . ' berhasil disetujui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses: ' . $e->getMessage());
        }
    }

    public function reject($id)
    {
        $trx = Transaksi::findOrFail($id);

        DB::beginTransaction();
        try {
            // Ubah status menjadi ditolak (Saldo TIDAK berubah)
            $trx->status = 'gagal';  // atau 'rejected' (sesuaikan dengan database)
            $trx->operator_id = auth()->id();
            $trx->save();

            DB::commit();
            return back()->with('success', 'Pengajuan penarikan a.n ' . $trx->user->nasabah->nama . ' telah ditolak.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses: ' . $e->getMessage());
        }
    }
}