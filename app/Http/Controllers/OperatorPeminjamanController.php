<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Nasabah;
use App\Http\Controllers\NotifikasiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OperatorPeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with('nasabah')
            ->where('status_verifikasi', 'disetujui')
            ->where('sisa_pinjaman', '>', 0)
            ->orderBy('tanggal_jatuh_tempo', 'asc')
            ->paginate(10);

        $totalAktif = Peminjaman::where('status_verifikasi', 'disetujui')
            ->where('sisa_pinjaman', '>', 0)
            ->sum('sisa_pinjaman');

        $totalPeminjam = Peminjaman::where('status_verifikasi', 'disetujui')
            ->where('sisa_pinjaman', '>', 0)
            ->distinct('id_nasabah')
            ->count('id_nasabah');

        $totalCicilanBulanIni = Peminjaman::where('status_verifikasi', 'disetujui')
            ->where('sisa_pinjaman', '>', 0)
            ->get()
            ->sum(function ($peminjaman) {
                return $peminjaman->jumlah_pinjaman / $peminjaman->tenor;
            });

        $jumlahCicilanBulanIni = Peminjaman::where('status_verifikasi', 'disetujui')
            ->where('sisa_pinjaman', '>', 0)
            ->count();

        $jatuhTempoBulanIni = Peminjaman::where('status_verifikasi', 'disetujui')
            ->where('sisa_pinjaman', '>', 0)
            ->whereMonth('tanggal_jatuh_tempo', date('m'))
            ->count();

        return view('operator.peminjaman.index', compact(
            'peminjamans',
            'totalAktif',
            'totalPeminjam',
            'totalCicilanBulanIni',
            'jumlahCicilanBulanIni',
            'jatuhTempoBulanIni'
        ));
    }

    public function create()
    {
        $nasabahs = Nasabah::with(['user', 'rekening'])
            ->where('kategori', 'guru')
            ->where('status', 'aktif')
            ->orderBy('nama', 'asc')
            ->get();

        return view('operator.peminjaman.create', compact('nasabahs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_nasabah' => 'required|exists:nasabah,id_nasabah',
            'jumlah_pinjaman' => 'required|numeric|min:50000',
            'tenor' => 'required|integer|min:1|max:24',
            'tanggal_ajuan' => 'required|date',
            'tanggal_jatuh_tempo' => 'required|date|after:tanggal_ajuan',
            'keterangan' => 'nullable|string|max:500',
        ], [
            'id_nasabah.required' => 'Nasabah harus dipilih terlebih dahulu.',
            'id_nasabah.exists' => 'Nasabah tidak ditemukan.',
            'jumlah_pinjaman.min' => 'Minimal pinjaman adalah Rp 50.000.',
            'tanggal_jatuh_tempo.after' => 'Tanggal jatuh tempo harus setelah tanggal pinjam.',
        ]);

        DB::beginTransaction();

        try {
            $nasabah = Nasabah::findOrFail($request->id_nasabah);

            $petugas = auth()->user()->petugas;

            if (!$petugas) {
                throw new \Exception('Data petugas untuk akun ini tidak ditemukan.');
            }

            Peminjaman::create([
                'id_nasabah' => $nasabah->id_nasabah,
                'id_petugas' => $petugas->id_petugas,
                'tanggal_ajuan' => $request->tanggal_ajuan,
                'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
                'jumlah_pinjaman' => $request->jumlah_pinjaman,
                'tenor' => $request->tenor,
                'sisa_pinjaman' => $request->jumlah_pinjaman,
                'keterangan' => $request->keterangan,
                'status_verifikasi' => 'disetujui',
            ]);

            DB::commit();

            return redirect()
                ->route('operator.peminjaman.index')
                ->with(
                    'success',
                    'Peminjaman a.n ' . $nasabah->nama . ' berhasil disimpan dan disetujui.'
                );
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Gagal menyimpan peminjaman: ' . $e->getMessage()
                );
        }
    }

    public function approve($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $nasabah = Nasabah::findOrFail($peminjaman->id_nasabah);

        DB::beginTransaction();

        try {
            $petugas = auth()->user()->petugas;

            if (!$petugas) {
                throw new \Exception('Data petugas untuk akun ini tidak ditemukan.');
            }

            $peminjaman->status_verifikasi = 'disetujui';
            $peminjaman->id_petugas = $petugas->id_petugas;
            $peminjaman->save();

            NotifikasiController::kirim(
                $nasabah->id_nasabah,
                'Pinjaman Disetujui',
                'Pinjaman Rp ' . number_format($peminjaman->jumlah_pinjaman, 0, ',', '.') . ' disetujui. Silakan ambil uang tunai di kantor BMT.',
                'peminjaman'
            );

            DB::commit();

            return back()->with(
                'success',
                'Pinjaman disetujui! Nasabah dapat mengambil uang di BMT.'
            );
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    public function reject($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $nasabah = Nasabah::findOrFail($peminjaman->id_nasabah);

        DB::beginTransaction();

        try {
            $petugas = auth()->user()->petugas;

            if (!$petugas) {
                throw new \Exception('Data petugas untuk akun ini tidak ditemukan.');
            }

            $peminjaman->status_verifikasi = 'ditolak';
            $peminjaman->id_petugas = $petugas->id_petugas;
            $peminjaman->save();

            NotifikasiController::kirim(
                $nasabah->id_nasabah,
                'Pinjaman Ditolak',
                'Pinjaman Rp ' . number_format($peminjaman->jumlah_pinjaman, 0, ',', '.') . ' ditolak oleh operator.',
                'peminjaman'
            );

            DB::commit();

            return back()->with('success', 'Pinjaman ditolak.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    public function indexVerifikasi()
    {
        $peminjamans = Peminjaman::with('nasabah.user')
            ->where('status_verifikasi', 'pending')
            ->orderBy('tanggal_ajuan', 'desc')
            ->paginate(10);

        $pendingCount = Peminjaman::where('status_verifikasi', 'pending')
            ->count();

        $approvedToday = Peminjaman::where('status_verifikasi', 'disetujui')
            ->whereDate('created_at', today())
            ->count();

        $rejectedToday = Peminjaman::where('status_verifikasi', 'ditolak')
            ->whereDate('created_at', today())
            ->count();

        return view('operator.verifikasi.peminjaman', compact(
            'peminjamans',
            'pendingCount',
            'approvedToday',
            'rejectedToday'
        ));
    }
}