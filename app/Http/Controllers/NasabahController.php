<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Nasabah;
use App\Models\RekeningTabungan;
use App\Models\DetailTabungan;
use App\Models\NomorRekeningCounter;
use App\Http\Controllers\NotifikasiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class NasabahController extends Controller
{
    public function index(Request $request)
    {
        $query = Nasabah::with(['user', 'rekening']);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('username', 'like', '%' . $search . '%')
                    ->orWhere('no_rek', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $nasabahs = $query->latest('id_nasabah')
            ->paginate(10)
            ->withQueryString();

        $totalNasabah = Nasabah::count();
        $nasabahAktif = Nasabah::where('status', 'aktif')->count();
        $nasabahNonaktif = Nasabah::where('status', '!=', 'aktif')->count();

        $nasabahBaru = Nasabah::whereMonth('tanggal_daftar', now()->month)
            ->whereYear('tanggal_daftar', now()->year)
            ->count();

        $totalSaldoTabungan = RekeningTabungan::sum('saldo');

        $jumlahBuku = DetailTabungan::where('status', 'berhasil')
            ->whereHas('jenisTransaksi', function ($q) {
                $q->whereRaw('LOWER(TRIM(setoran)) = ?', ['setoran']);
            })
            ->whereRaw('LOWER(keterangan) LIKE ?', ['%buku tabungan%'])
            ->count();

        $pendapatanBuku = $jumlahBuku * 5000;
        $totalSaldo = $totalSaldoTabungan + $pendapatanBuku;

        return view('operator.nasabah.index', compact(
            'nasabahs',
            'totalNasabah',
            'nasabahAktif',
            'nasabahNonaktif',
            'nasabahBaru',
            'totalSaldo'
        ));
    }

    public function create()
    {
        return view('operator.nasabah.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'username' => 'required|string|max:255|unique:users,username',
        'nama' => 'required|string|max:255',
        'kategori' => 'required|string|max:100',
        'prefix' => 'required|string|max:10',
        'alamat' => 'nullable|string',
        'saldo' => 'nullable|numeric|min:0',
        'tanggal_daftar' => 'required|date',
        'status' => 'required|string',
        'password' => 'nullable|string|min:6',
        'buku_tabungan' => 'required|in:tidak,terpisah,potong',
    ], [
        'username.required' => 'NISN / NIP wajib diisi.',
        'username.unique'   => 'NISN / NIP ini sudah terdaftar. Gunakan nomor lain.',
        'nama.required' => 'Nama lengkap wajib diisi.',
        'kategori.required' => 'Jenis nasabah wajib dipilih.',
        'prefix.required' => 'No. Rekening (prefix) wajib diisi.',
        'saldo.numeric' => 'Saldo awal harus berupa angka.',
        'saldo.min'     => 'Saldo awal tidak boleh negatif.',
        'tanggal_daftar.required' => 'Tanggal daftar wajib diisi.',
        'status.required' => 'Status wajib dipilih.',
        'password.min' => 'Password minimal 6 karakter.',
        'buku_tabungan.required' => 'Pilihan buku tabungan wajib dipilih.',
    ]);

    DB::beginTransaction();

    try {
        $saldoAwal = (int) ($request->saldo ?? 0);
        $biayaBuku = 5000;

        $totalDibayarNasabah = $saldoAwal;
        $saldoAkhirRekening = $saldoAwal;

        if ($request->buku_tabungan === 'terpisah') {
            $totalDibayarNasabah = $saldoAwal + $biayaBuku;
        }

        if ($request->buku_tabungan === 'potong') {
            if ($saldoAwal < $biayaBuku) {
                DB::rollBack();
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Saldo awal harus minimal Rp 5.000 jika biaya buku dipotong dari saldo.');
            }
            $saldoAkhirRekening = $saldoAwal - $biayaBuku;
        }

        $prefix = strtoupper(trim($request->prefix));
        $counter = NomorRekeningCounter::where('prefix', $prefix)
            ->lockForUpdate()
            ->first();

        if (!$counter) {
            $counter = NomorRekeningCounter::create([
                'prefix' => $prefix,
                'nomor_terakhir' => 0,
            ]);
        }

        $nextNumber = $counter->nomor_terakhir + 1;
        $counter->update(['nomor_terakhir' => $nextNumber]);

        $noRek = $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        // 1. Buat akun user
        $user = User::create([
            'username' => $request->username,
            'name' => $request->nama,
            'password' => Hash::make($request->password ?? 'nasabah123'),
            'role' => 'nasabah',
        ]);

        // 2. Buat data nasabah
        $nasabah = Nasabah::create([
            'username' => $user->username,
            'no_rek' => $noRek,
            'nama' => $request->nama,
            'kategori' => $request->kategori,
            'alamat' => $request->alamat,
            'tanggal_daftar' => $request->tanggal_daftar,
            'status' => $request->status,
        ]);

        // 3. Buat rekening
        RekeningTabungan::create([
            'no_rek' => $noRek,
            'id_nasabah' => $nasabah->id_nasabah,
            'saldo' => $saldoAkhirRekening,
        ]);

        // 4. Catat setoran awal
        if ($saldoAwal > 0) {
            $jenisSetoran = DB::table('jenis_transaksi')
                ->where('setoran', 'setoran')
                ->first();

            if ($jenisSetoran) {
                $petugas = auth()->user()->petugas;

                DetailTabungan::create([
                    'no_rek' => $noRek,
                    'id_petugas' => $petugas->id_petugas,
                    'id_jenis_transaksi' => $jenisSetoran->id_jenis_transaksi,
                    'jumlah' => $saldoAwal,
                    'tanggal_transaksi' => now('Asia/Jakarta'),
                    'status' => 'berhasil',
                    'keterangan' => 'Saldo Awal',
                ]);

                NotifikasiController::kirim(
                    $nasabah->id_nasabah,
                    'Setoran Awal Berhasil',
                    'Setoran awal sebesar Rp ' . number_format($saldoAwal, 0, ',', '.') . ' telah berhasil dicatat.',
                    'setoran'
                );
            }
        }

        // 5. Handle biaya buku
        if ($request->buku_tabungan === 'potong') {
            // PERBAIKAN: Hanya gunakan kolom yang ada
            $jenisBiaya = DB::table('jenis_transaksi')
                ->where('penarikan', 'penarikan')
                ->first();

            // Fallback: ambil transaksi kedua jika tidak ketemu
            if (!$jenisBiaya) {
                $jenisBiaya = DB::table('jenis_transaksi')
                    ->orderBy('id_jenis_transaksi', 'asc')
                    ->skip(1)
                    ->first();
            }

            if ($jenisBiaya) {
                $petugas = auth()->user()->petugas;

                DetailTabungan::create([
                    'no_rek' => $noRek,
                    'id_petugas' => $petugas->id_petugas,
                    'id_jenis_transaksi' => $jenisBiaya->id_jenis_transaksi,
                    'jumlah' => $biayaBuku,
                    'tanggal_transaksi' => now('Asia/Jakarta'),
                    'status' => 'berhasil',
                    'keterangan' => 'Potongan Biaya Buku Tabungan',
                ]);
            }
        }

        DB::commit();

        return redirect()
            ->route('operator.nasabah.index')
            ->with(
                'success',
                'Nasabah berhasil ditambahkan. Total pembayaran Rp ' .
                number_format($totalDibayarNasabah, 0, ',', '.') .
                ', saldo akhir rekening Rp ' .
                number_format($saldoAkhirRekening, 0, ',', '.') . '.'
            );

    } catch (\Throwable $e) {
        DB::rollBack();

        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Gagal menambahkan nasabah: ' . $e->getMessage());
    }
}

    public function edit($id)
    {
        $nasabah = Nasabah::with(['user', 'rekening'])->findOrFail($id);
        return view('operator.nasabah.edit', compact('nasabah'));
    }

    public function update(Request $request, $id)
    {
        $nasabah = Nasabah::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'alamat' => 'nullable|string',
            'tanggal_daftar' => 'required|date',
            'status' => 'required|string',
            'password' => 'nullable|string|min:6',
        ]);

        DB::beginTransaction();

        try {
            $nasabah->update([
                'nama' => $request->nama,
                'kategori' => $request->kategori,
                'alamat' => $request->alamat,
                'tanggal_daftar' => $request->tanggal_daftar,
                'status' => $request->status,
            ]);

            $nasabah->user->update([
                'name' => $request->nama,
            ]);

            if ($request->filled('password')) {
                $nasabah->user->update([
                    'password' => Hash::make($request->password),
                ]);
            }

            DB::commit();

            return redirect()
                ->route('operator.nasabah.index')
                ->with('success', 'Data nasabah berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui nasabah: ' . $e->getMessage());
        }
    }

    
    public function destroy($id)
    {
        $nasabah = Nasabah::with('rekening')->findOrFail($id);

        if ($nasabah->rekening) {
            $adaTransaksi = DetailTabungan::where(
                'no_rek',
                $nasabah->rekening->no_rek
            )->exists();

            if ($adaTransaksi) {
                return redirect()
                    ->back()
                    ->with('error', 'Nasabah tidak dapat dihapus karena sudah memiliki transaksi tabungan.');
            }

        }

        DB::beginTransaction();

        try {
            $username = $nasabah->username;
            $noRek = $nasabah->rekening
                ? $nasabah->rekening->no_rek
                : null;

            // Hapus notifikasi terkait nasabah terlebih dahulu jika
            // tabel notifikasi memiliki relasi ke data nasabah.
            if ($nasabah->rekening) {
                // Hapus riwayat transaksi rekening agar tidak menghalangi
                // penghapusan rekening karena foreign key.
                DetailTabungan::where('no_rek', $noRek)->delete();

                $nasabah->rekening()->delete();
            }

            // Hapus notifikasi yang masih terhubung ke nasabah.
            DB::table('notifikasi')
                ->where('id_nasabah', $nasabah->id_nasabah)
                ->delete();

            $nasabah->delete();

            // Hapus akun login nasabah.
            User::where('username', $username)->delete();

            DB::commit();

            return redirect()
                ->route('operator.nasabah.index')
                ->with('success', 'Nasabah berhasil dihapus.');

        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Gagal menghapus nasabah: ' . $e->getMessage()
                );
        }
    }

}