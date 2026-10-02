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
    // tampilkan daftar peminjaman aktif + hitung statistiknya
    public function index()
    {
        // ambil peminjaman yang disetujui & masih ada sisa, paginate 10
        $peminjamans = Peminjaman::with(['nasabah', 'angsurans'])
            ->where('status_verifikasi', 'disetujui')
            ->where('sisa_pinjaman', '>', 0)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // transform = ubah tiap item di collection sebelum dikirim ke view
        $peminjamans->getCollection()->transform(function ($peminjaman) {
            // hitung cicilan yang udah dibayar (yang ada pokoknya)
            // unique('cicilan_ke') biar gak dobel hitung
            $jumlahSudahDibayar = $peminjaman->angsurans
                ->where('jumlah_pokok', '>', 0)
                ->unique('cicilan_ke')
                ->count();
            
            // sisa cicilan = tenor - yang udah dibayar (minimal 0)
            $peminjaman->sisa_cicilan = max(0, $peminjaman->tenor - $jumlahSudahDibayar);
            $peminjaman->jumlah_sudah_dibayar = $jumlahSudahDibayar;
            
            return $peminjaman;
        });

        // total pinjaman aktif (sisa pokok semua)
        $totalAktif = Peminjaman::where('status_verifikasi', 'disetujui')
            ->where('sisa_pinjaman', '>', 0)
            ->sum('sisa_pinjaman');

        // total peminjam unik (nasabah yang beda)
        $totalPeminjam = Peminjaman::where('status_verifikasi', 'disetujui')
            ->where('sisa_pinjaman', '>', 0)
            ->distinct('id_nasabah')
            ->count('id_nasabah');

        // id semua pinjaman aktif
        $idPinjamanAktif = Peminjaman::where('status_verifikasi', 'disetujui')
            ->where('sisa_pinjaman', '>', 0)
            ->pluck('id_pinjaman');

        // total jasa yang udah dibayar dari pinjaman aktif
        $jasaAktif = Angsuran::whereIn('id_pinjaman', $idPinjamanAktif)
            ->sum('jumlah_jasa');

        // total provisi = 1% dari tiap pinjaman aktif
        $provisiAktif = Peminjaman::where('status_verifikasi', 'disetujui')
            ->where('sisa_pinjaman', '>', 0)
            ->get()
            ->sum(function ($peminjaman) {
                return $peminjaman->jumlah_pinjaman * 0.01;
            });

        // kirim ke view
        return view('operator.peminjaman.index', compact(
            'peminjamans',
            'totalAktif',
            'totalPeminjam',
            'jasaAktif',
            'provisiAktif'
        ));
    }

    // simpan peminjaman baru 
    public function store(Request $request)
    {
        // validasi input
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

        // mulai transaksi
        DB::beginTransaction();

        try {
            // cari nasabah & petugas yang login
            $nasabah = Nasabah::findOrFail($request->id_nasabah);
            $petugas = auth()->user()->petugas;

            // kalau gak ada data petugas, gagal
            if (!$petugas) {
                throw new \Exception('Data petugas untuk akun ini tidak ditemukan.');
            }

            // ambil jumlah & tenor
            $jumlahPinjaman = $request->jumlah_pinjaman;
            $tenor = $request->tenor;
            
            // hitung jasa (bunga) per bulan = 1%
            $jasaPerBulan = $jumlahPinjaman * 0.01;
            // total jasa = per bulan x tenor
            $totalJasa = $jasaPerBulan * $tenor;

            // simpan peminjaman baru dengan status langsung disetujui
            Peminjaman::create([
                'id_nasabah' => $nasabah->id_nasabah,
                'id_petugas' => $petugas->id_petugas,
                'tanggal_ajuan' => $request->tanggal_ajuan,
                'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
                'jumlah_pinjaman' => $jumlahPinjaman,
                'tenor' => $tenor,
                'sisa_pinjaman' => $jumlahPinjaman,
                'total_jasa' => $totalJasa,
                'jasa_per_bulan' => $jasaPerBulan,
                'sisa_jasa' => $totalJasa,
                'keterangan' => $request->keterangan,
                'status_verifikasi' => 'disetujui',
            ]);

            // simpan permanen
            DB::commit();

            // balikin ke index dengan pesan sukses
            return redirect()
                ->route('operator.peminjaman.index')
                ->with('success', 'Peminjaman a.n ' . $nasabah->nama . ' berhasil disimpan dan disetujui.');
        } catch (\Exception $e) {
            // kalau error, batalkan
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal menyimpan peminjaman: ' . $e->getMessage());
        }
    }

    // setujui pengajuan peminjaman
    public function approve($id)
    {
        // cari peminjaman & nasabahnya
        $peminjaman = Peminjaman::findOrFail($id);
        $nasabah = Nasabah::findOrFail($peminjaman->id_nasabah);

        // mulai transaksi
        DB::beginTransaction();

        try {
            // ambil petugas yang login
            $petugas = auth()->user()->petugas;

            // kalau gak ada, gagal
            if (!$petugas) {
                throw new \Exception('Data petugas untuk akun ini tidak ditemukan.');
            }

            // hitung provisi 1%
            $provisi = $peminjaman->jumlah_pinjaman * 0.01;
            
            // dana yang diterima nasabah = pinjaman - provisi
            $danaDiterima = $peminjaman->jumlah_pinjaman - $provisi;

            // update status jadi disetujui + catat petugasnya
            $peminjaman->status_verifikasi = 'disetujui';
            $peminjaman->id_petugas = $petugas->id_petugas;
            $peminjaman->save();

            // kirim notifikasi ke nasabah
            NotifikasiController::kirim(
                $nasabah->id_nasabah,
                'Pinjaman Disetujui',
                'Pinjaman Rp ' . number_format($peminjaman->jumlah_pinjaman, 0, ',', '.') . ' disetujui. Nasabah dapat menerima dana Rp ' . number_format($danaDiterima, 0, ',', '.') . ' (setelah potong provisi 1%) di loket BMT.',
                'peminjaman'
            );

            // simpan permanen
            DB::commit();
            return back()->with('success', 'Pinjaman disetujui! Nasabah dapat mengambil dana di BMT.');
            
        } catch (\Exception $e) {
            // kalau error, batalkan
            DB::rollBack();
            return back()->with('error', 'Gagal menyetujui: ' . $e->getMessage());
        }
    }

    // tolak pengajuan peminjaman
    public function reject($id)
    {
        // cari peminjaman & nasabahnya
        $peminjaman = Peminjaman::findOrFail($id);
        $nasabah = Nasabah::findOrFail($peminjaman->id_nasabah);

        // mulai transaksi
        DB::beginTransaction();

        try {
            // ambil petugas yang login
            $petugas = auth()->user()->petugas;

            // kalau gak ada, gagal
            if (!$petugas) {
                throw new \Exception('Data petugas untuk akun ini tidak ditemukan.');
            }

            // update status jadi ditolak + catat petugasnya
            $peminjaman->status_verifikasi = 'ditolak';
            $peminjaman->id_petugas = $petugas->id_petugas;
            $peminjaman->save();

            // kirim notifikasi ke nasabah
            NotifikasiController::kirim(
                $nasabah->id_nasabah,
                'Pinjaman Ditolak',
                'Pinjaman Rp ' . number_format($peminjaman->jumlah_pinjaman, 0, ',', '.') . ' ditolak oleh operator.',
                'peminjaman'
            );

            // simpan permanen
            DB::commit();
            return back()->with('success', 'Pinjaman ditolak.');
        } catch (\Exception $e) {
            // kalau error, batalkan
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    // tampilkan halaman verifikasi peminjaman (yang pending)
    public function indexVerifikasi()
    {
        // ambil peminjaman yang masih pending, paginate 10
        $peminjamans = Peminjaman::with('nasabah.user')
            ->where('status_verifikasi', 'pending')
            ->orderBy('tanggal_ajuan', 'desc')
            ->paginate(10);

        // hitung buat badge di sidebar kanan
        $pendingCount = Peminjaman::where('status_verifikasi', 'pending')->count();
        $approvedToday = Peminjaman::where('status_verifikasi', 'disetujui')->whereDate('created_at', today())->count();
        $rejectedToday = Peminjaman::where('status_verifikasi', 'ditolak')->whereDate('created_at', today())->count();

        // kirim ke view
        return view('operator.verifikasi.peminjaman', compact(
            'peminjamans',
            'pendingCount',
            'approvedToday',
            'rejectedToday'
        ));
    }

    // ambil mutasi untuk satu pinjaman (buat modal mutasi)
    public function getMutasiPerPinjaman($id_pinjaman)
    {
        try {
            // log buat debugging
            Log::info('getMutasiPerPinjaman called with ID: ' . $id_pinjaman);

            // cari pinjaman + nasabahnya
            $pinjaman = Peminjaman::with('nasabah')->findOrFail($id_pinjaman);
            
            // kalau gak ketemu, error
            if (!$pinjaman) {
                throw new \Exception('Pinjaman tidak ditemukan');
            }

            // ambil nasabah
            $nasabah = $pinjaman->nasabah;
            
            // kalau gak ada, error
            if (!$nasabah) {
                throw new \Exception('Data nasabah tidak ditemukan');
            }

            Log::info('Pinjaman found: ' . json_encode($pinjaman->toArray()));

            // ambil angsuran yang ada pokoknya aja (biar mutasi bersih)
            // urut dari yang paling lama
            $angsurans = Angsuran::where('id_pinjaman', $id_pinjaman)
                ->where('jumlah_pokok', '>', 0)
                ->orderBy('tanggal_pembayaran', 'asc')
                ->get();

            Log::info('Found ' . $angsurans->count() . ' angsuran records with pokok payment');

            // siapin array mutasi
            $transaksi = [];
            $totalDebet = 0;
            $totalKredit = 0;
            $saldoBerjalan = 0;

            // tambah baris pencairan (debit = pinjaman keluar)
            $jumlahPinjaman = (int)$pinjaman->jumlah_pinjaman;
            $transaksi[] = [
                'tanggal' => \Carbon\Carbon::parse($pinjaman->tanggal_ajuan)->format('d/m/Y'),
                'keterangan' => 'Pencairan Pinjaman' . ($pinjaman->keterangan ? ' - ' . $pinjaman->keterangan : ''),
                'debit' => $jumlahPinjaman,
                'kredit' => 0,
                'jenis' => 'pencairan',
                'jenis_display' => 'PENCAIRAN',
                'saldo' => $jumlahPinjaman,
            ];
            $totalDebet += $jumlahPinjaman;
            $saldoBerjalan = $jumlahPinjaman;

            // tambah baris angsuran (kredit = pokok yang dibayar)
            foreach ($angsurans as $angsuran) {
                $jumlahPokok = (int)($angsuran->jumlah_pokok ?? 0);
                
                // skip kalau pokoknya 0
                if ($jumlahPokok <= 0) {
                    continue;
                }
                
                // kurangi saldo hutang
                $saldoBerjalan -= $jumlahPokok;
                
                $transaksi[] = [
                    'tanggal' => \Carbon\Carbon::parse($angsuran->tanggal_pembayaran)->format('d/m/Y'),
                    'keterangan' => 'Pembayaran Cicilan',
                    'debit' => 0,
                    'kredit' => $jumlahPokok,
                    'pokok' => $jumlahPokok,
                    'jasa' => (int)($angsuran->jumlah_jasa ?? 0),
                    'jenis' => 'pembayaran',
                    'jenis_display' => 'PEMBAYARAN',
                    'saldo' => $saldoBerjalan,
                ];
                $totalKredit += $jumlahPokok;
            }

            // susun response
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
            
            // kirim response json
            return response()->json($responseData);

        } catch (\Exception $e) {
            // log error
            Log::error('Error in getMutasiPerPinjaman: ' . $e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());
            
            // kirim response error
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data: ' . $e->getMessage()
            ], 500);
        }
    }

    // ambil mutasi semua pinjaman milik 1 nasabah
    public function getRekeningData($id_nasabah)
    {
        try {
            // cari nasabah
            $nasabah = Nasabah::findOrFail($id_nasabah);
            
            // ambil semua pinjaman nasabah ini
            $peminjamans = Peminjaman::where('id_nasabah', $id_nasabah)
                ->orderBy('tanggal_ajuan', 'asc')
                ->get();

            // kalau gak ada pinjaman, kirim response kosong
            if ($peminjamans->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nasabah ini belum memiliki riwayat peminjaman.'
                ]);
            }

            // siapin array hasil
            $peminjamanList = [];
            $grandTotalDebet = 0;
            $grandTotalKredit = 0;

            // loop tiap pinjaman
            foreach ($peminjamans as $pinjaman) {
                // ambil angsuran pinjaman ini
                $angsurans = Angsuran::where('id_pinjaman', $pinjaman->id_pinjaman)
                    ->orderBy('tanggal_pembayaran', 'asc')
                    ->get();

                $transaksi = [];
                $totalDebet = 0;
                $totalKredit = 0;
                $saldoBerjalan = 0;

                // baris pencairan
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

                // baris angsuran
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

                // tambah ke list
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

                // tambah ke grand total
                $grandTotalDebet += $totalDebet;
                $grandTotalKredit += $totalKredit;
            }

            // grand total saldo = total sisa pinjaman
            $grandTotalSaldo = $peminjamans->sum('sisa_pinjaman');

            // kirim response json
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
            // kirim response error
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data: ' . $e->getMessage()
            ], 500);
        }
    }

    // tampilkan form input peminjaman baru
    public function create()
    {
        // ambil nasabah kategori guru yang aktif aja
        $nasabahs = Nasabah::with(['user', 'rekening'])
            ->where('kategori', 'guru')
            ->where('status', 'aktif')
            ->orderBy('nama', 'asc')
            ->get();

        // kirim ke view
        return view('operator.peminjaman.create', compact('nasabahs'));
    }
}