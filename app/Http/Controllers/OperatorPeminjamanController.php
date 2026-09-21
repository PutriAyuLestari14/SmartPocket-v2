<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Nasabah;
use App\Models\Angsuran; // <-- Ditambahkan untuk ambil data cicilan
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
            ->orderBy('created_at', 'desc')
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
            ->distinct('id_nasabah')
            ->count('id_nasabah');

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
                ->with('success', 'Peminjaman a.n ' . $nasabah->nama . ' berhasil disimpan dan disetujui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan peminjaman: ' . $e->getMessage());
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
            return back()->with('success', 'Pinjaman disetujui! Nasabah dapat mengambil uang di BMT.');
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

        $pendingCount = Peminjaman::where('status_verifikasi', 'pending')->count();
        $approvedToday = Peminjaman::where('status_verifikasi', 'disetujui')->whereDate('created_at', today())->count();
        $rejectedToday = Peminjaman::where('status_verifikasi', 'ditolak')->whereDate('created_at', today())->count();

        return view('operator.verifikasi.peminjaman', compact(
            'peminjamans',
            'pendingCount',
            'approvedToday',
            'rejectedToday'
        ));
    }

    // =========================================================
    // METHOD BARU: Ambil Data Mutasi PEMINJAMAN SAJA (Bukan Tabungan)
    // =========================================================
    public function getRekeningData($id_nasabah)
    {
        try {
            // 1. Ambil data nasabah
            $nasabah = Nasabah::findOrFail($id_nasabah);
            
            // 2. Ambil semua riwayat peminjaman nasabah ini (diurutkan dari yang lama)
            $peminjamans = Peminjaman::where('id_nasabah', $id_nasabah)
            ->where('status_verifikasi', 'disetujui')
            ->orderBy('tanggal_ajuan', 'asc')
            ->get();

            if ($peminjamans->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nasabah ini belum memiliki riwayat peminjaman.'
                ]);
            }

            // 3. Ambil semua angsuran (pembayaran cicilan) untuk pinjaman-pinjaman tersebut
            $idPinjamanList = $peminjamans->pluck('id_pinjaman');
            $angsurans = Angsuran::whereIn('id_pinjaman', $idPinjamanList)
                ->orderBy('tanggal_pembayaran', 'asc')
                ->get();

            // 4. Gabungkan jadi satu timeline transaksi
            $transaksi = [];
            $totalPinjaman = 0;
            $totalPembayaran = 0;

            // Masukkan data Pencairan Pinjaman sebagai DEBET (Hutang bertambah)
            foreach ($peminjamans as $pinjaman) {
                $transaksi[] = [
                    'tanggal' => \Carbon\Carbon::parse($pinjaman->tanggal_ajuan)->format('d/m/Y'),
                    'keterangan' => 'Pencairan Pinjaman' . ($pinjaman->keterangan ? ' - ' . $pinjaman->keterangan : ''),
                    'debit' => $pinjaman->jumlah_pinjaman,
                    'kredit' => 0,
                ];
                $totalPinjaman += $pinjaman->jumlah_pinjaman;
            }

            // Masukkan data Pembayaran Cicilan sebagai KREDIT (Hutang berkurang)
            foreach ($angsurans as $angsuran) {
                $transaksi[] = [
                    'tanggal' => \Carbon\Carbon::parse($angsuran->tanggal_pembayaran)->format('d/m/Y'),
                    'keterangan' => 'Pembayaran Cicilan',
                    'debit' => 0,
                    'kredit' => $angsuran->jumlah,
                ];
                $totalPembayaran += $angsuran->jumlah;
            }

            // 5. Urutkan ulang seluruh transaksi berdasarkan tanggal (ascending / lama ke baru)
            usort($transaksi, function($a, $b) {
                return strtotime(str_replace('/', '-', $a['tanggal'])) - strtotime(str_replace('/', '-', $b['tanggal']));
            });

            $sisaPinjaman = $totalPinjaman - $totalPembayaran;

            return response()->json([
                'success' => true,
                'nasabah' => [
                    'no_rek' => $nasabah->no_rek ?? '-',
                    'nama' => $nasabah->nama,
                ],
                'total_pinjaman' => $totalPinjaman,
                'total_pembayaran' => $totalPembayaran,
                'sisa_pinjaman' => $sisaPinjaman,
                'transaksi' => $transaksi,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data: ' . $e->getMessage()
            ], 500);
        }
    }
}