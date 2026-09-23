<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Nasabah;
use App\Models\Angsuran; 
use App\Models\RekeningTabungan; 
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

            $jumlahPinjaman = $request->jumlah_pinjaman;
            $tenor = $request->tenor;
            
            $bungaPerBulan = $jumlahPinjaman * 0.01;
            $totalBunga = $bungaPerBulan * $tenor;

            // HANYA simpan data pinjaman - JANGAN sentuh saldo tabungan!
            Peminjaman::create([
                'id_nasabah' => $nasabah->id_nasabah,
                'id_petugas' => $petugas->id_petugas,
                'tanggal_ajuan' => $request->tanggal_ajuan,
                'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
                'jumlah_pinjaman' => $jumlahPinjaman,
                'tenor' => $tenor,
                'sisa_pinjaman' => $jumlahPinjaman,
                'total_bunga' => $totalBunga,
                'bunga_per_bulan' => $bungaPerBulan,
                'sisa_bunga' => $totalBunga,
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

            // Hitung provisi 1% (hanya untuk info/notifikasi)
            $provisi = $peminjaman->jumlah_pinjaman * 0.01;
            $danaDiterima = $peminjaman->jumlah_pinjaman - $provisi;

            // Update status pinjaman - JANGAN sentuh saldo tabungan!
            $peminjaman->status_verifikasi = 'disetujui';
            $peminjaman->id_petugas = $petugas->id_petugas;
            $peminjaman->save();

            // Kirim notifikasi
            NotifikasiController::kirim(
                $nasabah->id_nasabah,
                'Pinjaman Disetujui',
                'Pinjaman Rp ' . number_format($peminjaman->jumlah_pinjaman, 0, ',', '.') . ' disetujui. Nasabah dapat menerima dana Rp ' . number_format($danaDiterima, 0, ',', '.') . ' (setelah potong provisi 1%) di loket BMT.',
                'peminjaman'
            );

            DB::commit();
            return back()->with('success', 'Pinjaman disetujui! Nasabah dapat mengambil dana di BMT.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyetujui: ' . $e->getMessage());
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

    public function getRekeningData($id_nasabah)
    {
        try {
            $nasabah = Nasabah::findOrFail($id_nasabah);
            
            $peminjamans = Peminjaman::where('id_nasabah', $id_nasabah)
                ->orderBy('tanggal_ajuan', 'asc')
                ->get();

            if ($peminjamans->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nasabah ini belum memiliki riwayat peminjaman.'
                ]);
            }

            $idPinjamanList = $peminjamans->pluck('id_pinjaman');
            $angsurans = Angsuran::whereIn('id_pinjaman', $idPinjamanList)
                ->orderBy('tanggal_pembayaran', 'asc')
                ->get();

            $transaksi = [];
            $totalPinjaman = 0;
            $totalPembayaran = 0;

            foreach ($peminjamans as $pinjaman) {
                $transaksi[] = [
                    'tanggal' => \Carbon\Carbon::parse($pinjaman->tanggal_ajuan)->format('d/m/Y'),
                    'keterangan' => 'Pencairan Pinjaman' . ($pinjaman->keterangan ? ' - ' . $pinjaman->keterangan : ''),
                    'debit' => $pinjaman->jumlah_pinjaman,
                    'kredit' => 0,
                    'jenis' => 'pencairan',
                ];
                $totalPinjaman += $pinjaman->jumlah_pinjaman;
            }

            foreach ($angsurans as $angsuran) {
                $transaksi[] = [
                    'tanggal' => \Carbon\Carbon::parse($angsuran->tanggal_pembayaran)->format('d/m/Y'),
                    'keterangan' => 'Pembayaran Cicilan',
                    'debit' => 0,
                    'kredit' => $angsuran->jumlah,
                    'jenis' => $angsuran->jenis_pembayaran ?? 'pokok',
                ];
                $totalPembayaran += $angsuran->jumlah;
            }

            usort($transaksi, function($a, $b) {
                return strtotime(str_replace('/', '-', $a['tanggal'])) - strtotime(str_replace('/', '-', $b['tanggal']));
            });

            return response()->json([
                'success' => true,
                'nasabah' => [
                    'no_rek' => $nasabah->no_rek ?? '-',
                    'nama' => $nasabah->nama,
                ],
                'total_pinjaman' => $totalPinjaman,
                'total_pembayaran' => $totalPembayaran,
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