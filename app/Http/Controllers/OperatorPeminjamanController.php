<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Nasabah;
use App\Models\Angsuran; 
use App\Models\RekeningTabungan; 
use App\Http\Controllers\NotifikasiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

        $idPinjamanAktif = Peminjaman::where('status_verifikasi', 'disetujui')
            ->where('sisa_pinjaman', '>', 0)
            ->pluck('id_pinjaman');

        $jasaAktif = Angsuran::whereIn('id_pinjaman', $idPinjamanAktif)
            ->sum('jumlah_jasa');

        $provisiAktif = Peminjaman::where('status_verifikasi', 'disetujui')
            ->where('sisa_pinjaman', '>', 0)
            ->get()
            ->sum(function ($peminjaman) {
                return $peminjaman->jumlah_pinjaman * 0.01;
            });

        return view('operator.peminjaman.index', compact(
            'peminjamans',
            'totalAktif',
            'totalPeminjam',
            'jasaAktif',
            'provisiAktif'
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

            $provisi = $peminjaman->jumlah_pinjaman * 0.01;
            $danaDiterima = $peminjaman->jumlah_pinjaman - $provisi;

            $peminjaman->status_verifikasi = 'disetujui';
            $peminjaman->id_petugas = $petugas->id_petugas;
            $peminjaman->save();

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

    /**
     * Get mutasi untuk SATU pinjaman tertentu
     */
    public function getMutasiPerPinjaman($id_pinjaman)
    {
        try {
            Log::info('getMutasiPerPinjaman called with ID: ' . $id_pinjaman);

            // Find pinjaman with nasabah
            $pinjaman = Peminjaman::with('nasabah')->findOrFail($id_pinjaman);
            
            if (!$pinjaman) {
                throw new \Exception('Pinjaman tidak ditemukan');
            }

            $nasabah = $pinjaman->nasabah;
            
            if (!$nasabah) {
                throw new \Exception('Data nasabah tidak ditemukan');
            }

            Log::info('Pinjaman found: ' . json_encode($pinjaman->toArray()));

            // Get angsuran for this pinjaman only
            $angsurans = Angsuran::where('id_pinjaman', $id_pinjaman)
                ->orderBy('tanggal_pembayaran', 'asc')
                ->get();

            Log::info('Found ' . $angsurans->count() . ' angsuran records');

            $transaksi = [];
            $totalDebet = 0;
            $totalKredit = 0;
            $saldoBerjalan = 0;

            // 1. Transaksi Pencairan
            $jumlahPinjaman = (int)$pinjaman->jumlah_pinjaman;
            $transaksi[] = [
                'tanggal' => \Carbon\Carbon::parse($pinjaman->tanggal_ajuan)->format('d/m/Y'),
                'keterangan' => 'Pencairan Pinjaman' . ($pinjaman->keterangan ? ' - ' . $pinjaman->keterangan : ''),
                'debit' => $jumlahPinjaman,
                'kredit' => 0,
                'jenis' => 'pencairan',
                'saldo' => $jumlahPinjaman,
            ];
            $totalDebet += $jumlahPinjaman;
            $saldoBerjalan = $jumlahPinjaman;

            // 2. Transaksi Angsuran
            foreach ($angsurans as $angsuran) {
                $jumlahPokok = (int)($angsuran->jumlah_pokok ?? 0);
                $saldoBerjalan -= $jumlahPokok;
                
                $transaksi[] = [
                    'tanggal' => \Carbon\Carbon::parse($angsuran->tanggal_pembayaran)->format('d/m/Y'),
                    'keterangan' => 'Pembayaran Cicilan',
                    'debit' => 0,
                    'kredit' => $jumlahPokok,
                    'pokok' => $jumlahPokok,
                    'jasa' => (int)($angsuran->jumlah_jasa ?? 0),
                    'jenis' => $angsuran->jenis_pembayaran ?? 'pokok',
                    'saldo' => $saldoBerjalan,
                ];
                $totalKredit += $jumlahPokok;
            }

            $responseData = [
                'success' => true,
                'pinjaman' => [
                    'id_pinjaman' => $pinjaman->id_pinjaman,
                    'tanggal_ajuan' => \Carbon\Carbon::parse($pinjaman->tanggal_ajuan)->format('d/m/Y'),
                    'jumlah_pinjaman' => $jumlahPinjaman,
                    'tenor' => $pinjaman->tenor,
                    'sisa_pinjaman' => (int)$pinjaman->sisa_pinjaman,
                    'status' => $pinjaman->status_verifikasi,
                ],
                'nasabah' => [
                    'no_rek' => $nasabah->no_rek ?? '-',
                    'nama' => $nasabah->nama,
                ],
                'transaksi' => $transaksi,
                'total_debet' => $totalDebet,
                'total_kredit' => $totalKredit,
                'saldo_akhir' => $saldoBerjalan,
            ];

            Log::info('Returning response: ' . json_encode($responseData));
            
            return response()->json($responseData);

        } catch (\Exception $e) {
            Log::error('Error in getMutasiPerPinjaman: ' . $e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get semua data rekening (untuk backward compatibility)
     */
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

            $peminjamanList = [];
            $grandTotalDebet = 0;
            $grandTotalKredit = 0;

            foreach ($peminjamans as $pinjaman) {
                $angsurans = Angsuran::where('id_pinjaman', $pinjaman->id_pinjaman)
                    ->orderBy('tanggal_pembayaran', 'asc')
                    ->get();

                $transaksi = [];
                $totalDebet = 0;
                $totalKredit = 0;
                $saldoBerjalan = 0;

                $transaksi[] = [
                    'tanggal' => \Carbon\Carbon::parse($pinjaman->tanggal_ajuan)->format('d/m/Y'),
                    'keterangan' => 'Pencairan Pinjaman' . ($pinjaman->keterangan ? ' - ' . $pinjaman->keterangan : ''),
                    'debit' => $pinjaman->jumlah_pinjaman,
                    'kredit' => 0,
                    'jenis' => 'pencairan',
                    'saldo' => $pinjaman->jumlah_pinjaman,
                ];
                $totalDebet += $pinjaman->jumlah_pinjaman;
                $saldoBerjalan = $pinjaman->jumlah_pinjaman;

                foreach ($angsurans as $angsuran) {
                    $saldoBerjalan -= $angsuran->jumlah_pokok;
                    $transaksi[] = [
                        'tanggal' => \Carbon\Carbon::parse($angsuran->tanggal_pembayaran)->format('d/m/Y'),
                        'keterangan' => 'Pembayaran Cicilan',
                        'debit' => 0,
                        'kredit' => $angsuran->jumlah_pokok,
                        'pokok' => $angsuran->jumlah_pokok,
                        'jasa' => $angsuran->jumlah_jasa,
                        'jenis' => $angsuran->jenis_pembayaran ?? 'pokok',
                        'saldo' => $saldoBerjalan,
                    ];
                    $totalKredit += $angsuran->jumlah_pokok;
                }

                $peminjamanList[] = [
                    'id_pinjaman' => $pinjaman->id_pinjaman,
                    'tanggal_ajuan' => \Carbon\Carbon::parse($pinjaman->tanggal_ajuan)->format('d/m/Y'),
                    'jumlah_pinjaman' => $pinjaman->jumlah_pinjaman,
                    'tenor' => $pinjaman->tenor,
                    'sisa_pinjaman' => $pinjaman->sisa_pinjaman,
                    'status' => $pinjaman->status_verifikasi,
                    'transaksi' => $transaksi,
                    'total_debet' => $totalDebet,
                    'total_kredit' => $totalKredit,
                    'saldo_akhir' => $saldoBerjalan,
                ];

                $grandTotalDebet += $totalDebet;
                $grandTotalKredit += $totalKredit;
            }

            $grandTotalSaldo = $peminjamans->sum('sisa_pinjaman');

            return response()->json([
                'success' => true,
                'nasabah' => [
                    'no_rek' => $nasabah->no_rek ?? '-',
                    'nama' => $nasabah->nama,
                ],
                'peminjaman_list' => $peminjamanList,
                'grand_total_debet' => $grandTotalDebet,
                'grand_total_kredit' => $grandTotalKredit,
                'grand_total_saldo' => $grandTotalSaldo,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data: ' . $e->getMessage()
            ], 500);
        }
    }
}