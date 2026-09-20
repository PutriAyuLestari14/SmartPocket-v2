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
        // ambil data pinjaman yang udah disetujui & belum lunas
        // biar operator bisa pantau siapa aja yang masih ada pinjaman & kapan jatuh temponya
        $peminjamans = Peminjaman::with('nasabah')
            ->where('status_verifikasi', 'disetujui')
            ->where('sisa_pinjaman', '>', 0)
            ->orderBy('tanggal_jatuh_tempo', 'asc')
            ->paginate(10);

        // hitung total sisa hutang semua nasabah yang masih aktif
        $totalAktif = Peminjaman::where('status_verifikasi', 'disetujui')
            ->where('sisa_pinjaman', '>', 0)
            ->sum('sisa_pinjaman');

        // hitung ada berapa orang unik yang lagi punya hutang
        $totalPeminjam = Peminjaman::where('status_verifikasi', 'disetujui')
            ->where('sisa_pinjaman', '>', 0)
            ->distinct('id_nasabah')
            ->count('id_nasabah');

        // estimasi total cicilan yang harusnya masuk bulan ini (jumlah / tenor)
        $totalCicilanBulanIni = Peminjaman::where('status_verifikasi', 'disetujui')
            ->where('sisa_pinjaman', '>', 0)
            ->get()
            ->sum(function ($peminjaman) {
                return $peminjaman->jumlah_pinjaman / $peminjaman->tenor;
            });

        // hitung total jumlah cicilan yang harus dibayar bulan ini
        $jumlahCicilanBulanIni = Peminjaman::where('status_verifikasi', 'disetujui')
            ->where('sisa_pinjaman', '>', 0)
            ->count();

        // hitung berapa banyak pinjaman yang jatuh tempo di bulan ini
        $jatuhTempoBulanIni = Peminjaman::where('status_verifikasi', 'disetujui')
            ->where('sisa_pinjaman', '>', 0)
            ->whereMonth('tanggal_jatuh_tempo', date('m'))
            ->count();

        // lempar semua data ke view biar bisa dipajang di dashboard operator
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
        // nyiapin data nasabah khusus kategori guru yang masih aktif
        // biar pas operator input manual nggak salah pilih orang atau pilih siswa
        $nasabahs = Nasabah::with(['user', 'rekening'])
            ->where('kategori', 'guru')
            ->where('status', 'aktif')
            ->orderBy('nama', 'asc')
            ->get();

        return view('operator.peminjaman.create', compact('nasabahs'));
    }

    public function store(Request $request)
    {
        // validasi dulu inputannya, jangan sampe ada data aneh yang lolos
        // custom message juga udah disetup biar errornya lebih relate & jelas
        $request->validate([
            'id_nasabah' => 'required|exists:nasabah,id_nasabah',
            'jumlah_pinjaman' => 'required|numeric|min:50000',
            'tenor' => 'required|integer|min:1|max:24',
            'tanggal_ajuan' => 'required|date',
            'tanggal_jatuh_tempo' => 'required|date|after:tanggal_ajuan',
            'keterangan' => 'nullable|string|max:500',
        ], [
            'id_nasabah.required' => 'nasabah harus dipilih terlebih dahulu.',
            'id_nasabah.exists' => 'nasabah tidak ditemukan.',
            'jumlah_pinjaman.min' => 'minimal pinjaman adalah rp 50.000.',
            'tanggal_jatuh_tempo.after' => 'tanggal jatuh tempo harus setelah tanggal pinjam.',
        ]);

        // pake db transaction biar aman, no drama rollback kalau ada error di tengah jalan
        DB::beginTransaction();

        try {
            $nasabah = Nasabah::findOrFail($request->id_nasabah);

            // pastikan petugas yang login itu valid & ada datanya
            $petugas = auth()->user()->petugas;

            if (!$petugas) {
                throw new \Exception('data petugas untuk akun ini tidak ditemukan.');
            }

            // simpen data peminjaman ke database, status langsung disetujui karena ini input manual operator
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

            // commit transaction, data udah aman tersimpan
            DB::commit();

            return redirect()
                ->route('operator.peminjaman.index')
                ->with(
                    'success',
                    'peminjaman a.n ' . $nasabah->nama . ' berhasil disimpan dan disetujui.'
                );
        } catch (\Exception $e) {
            // kalau ada error, batalkan semua proses biar data nggak corrupt
            DB::rollBack();

            return back()
                ->withInput()
                ->with(
                    'error',
                    'gagal menyimpan peminjaman: ' . $e->getMessage()
                );
        }
    }

    public function approve($id)
    {
        // ambil data pinjaman & nasabah yang mau di-approve
        $peminjaman = Peminjaman::findOrFail($id);
        $nasabah = Nasabah::findOrFail($peminjaman->id_nasabah);

        DB::beginTransaction();

        try {
            $petugas = auth()->user()->petugas;

            if (!$petugas) {
                throw new \Exception('data petugas untuk akun ini tidak ditemukan.');
            }

            // ubah status jadi disetujui & catet siapa petugas yang approve
            $peminjaman->status_verifikasi = 'disetujui';
            $peminjaman->id_petugas = $petugas->id_petugas;
            $peminjaman->save();

            // kirim notif ke nasabah biar dia tau 
            NotifikasiController::kirim(
                $nasabah->id_nasabah,
                'pinjaman disetujui',
                'pinjaman rp ' . number_format($peminjaman->jumlah_pinjaman, 0, ',', '.') . ' disetujui. silakan ambil uang tunai di kantor bmt.',
                'peminjaman'
            );

            DB::commit();

            return back()->with(
                'success',
                'pinjaman disetujui! nasabah dapat mengambil uang di bmt.'
            );
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    public function reject($id)
    {
        // ambil data pinjaman & nasabah yang mau ditolak
        $peminjaman = Peminjaman::findOrFail($id);
        $nasabah = Nasabah::findOrFail($peminjaman->id_nasabah);

        DB::beginTransaction();

        try {
            $petugas = auth()->user()->petugas;

            if (!$petugas) {
                throw new \Exception('data petugas untuk akun ini tidak ditemukan.');
            }

            // ubah status jadi ditolak & catet petugas yang reject
            $peminjaman->status_verifikasi = 'ditolak';
            $peminjaman->id_petugas = $petugas->id_petugas;
            $peminjaman->save();

            // kasih tau nasabah lewat notif biar nggak nungguin ghosting 
            NotifikasiController::kirim(
                $nasabah->id_nasabah,
                'pinjaman ditolak',
                'pinjaman rp ' . number_format($peminjaman->jumlah_pinjaman, 0, ',', '.') . ' ditolak oleh operator.',
                'peminjaman'
            );

            DB::commit();

            return back()->with('success', 'pinjaman ditolak.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    public function indexVerifikasi()
    {
        // halaman khusus buat ngecek pengajuan yang masih pending
        $peminjamans = Peminjaman::with('nasabah.user')
            ->where('status_verifikasi', 'pending')
            ->orderBy('tanggal_ajuan', 'desc')
            ->paginate(10);

        // hitung statistik buat dashboard biar keliatan pro
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