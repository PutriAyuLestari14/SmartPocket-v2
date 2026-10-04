<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Nasabah;
use App\Models\RekeningTabungan;
use App\Models\DetailTabungan;
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

        // ambil data nasabah
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

        // kirim data ke halaman
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
        ]);

        DB::beginTransaction();

        try {
            $saldoAwal = (int) ($request->saldo ?? 0);
            $biayaBuku = 5000;

            // tentukan saldo yang masuk ke rekening
            $saldoMasukRekening = $saldoAwal;
            $totalDibayarNasabah = $saldoAwal;
            $keteranganSetoran = 'Saldo Awal';

            if ($request->buku_tabungan === 'terpisah') {
                $totalDibayarNasabah = $saldoAwal + $biayaBuku;
                $keteranganSetoran = 'Saldo Awal - Buku Tabungan Terpisah';
            }

            if ($request->buku_tabungan === 'potong') {
                if ($saldoAwal < $biayaBuku) {
                    DB::rollBack();

                    return redirect()
                        ->back()
                        ->withInput()
                        ->with('error', 'Saldo awal harus minimal Rp 5.000 jika biaya buku dipotong dari saldo.');
                }

                $saldoMasukRekening = $saldoAwal - $biayaBuku;
                $keteranganSetoran = 'Saldo Awal - Buku Tabungan Potong dari Saldo';
            }

            $prefix = strtoupper(trim($request->prefix));

            // buat nomor rekening berikutnya
            $lastRekening = RekeningTabungan::where('no_rek', 'like', $prefix . '%')
                ->orderBy('no_rek', 'desc')
                ->first();

            if ($lastRekening) {
                $lastNumber = (int) substr(
                    $lastRekening->no_rek,
                    strlen($prefix)
                );
                $nextNumber = $lastNumber + 1;
            } else {
                $nextNumber = 1;
            }

            $noRek = $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            // buat akun user nasabah
            $user = User::create([
                'username' => $request->username,
                'name' => $request->nama,
                'password' => Hash::make($request->password ?? 'nasabah123'),
                'role' => 'nasabah',
            ]);

            // buat data nasabah
            $nasabah = Nasabah::create([
                'username' => $user->username,
                'no_rek' => $noRek,
                'nama' => $request->nama,
                'kategori' => $request->kategori,
                'alamat' => $request->alamat,
                'tanggal_daftar' => $request->tanggal_daftar,
                'status' => $request->status,
            ]);

            // buat rekening tabungan
            RekeningTabungan::create([
                'no_rek' => $noRek,
                'id_nasabah' => $nasabah->id_nasabah,
                'saldo' => $saldoMasukRekening,
            ]);

            // catat saldo awal yang benar-benar masuk ke tabungan
            if ($saldoMasukRekening > 0) {
                $jenisSetoran = DB::table('jenis_transaksi')
                    ->where('setoran', 'setoran')
                    ->first();

                if ($jenisSetoran) {
                    $petugas = auth()->user()->petugas;

                    DetailTabungan::create([
                        'no_rek' => $noRek,
                        'id_petugas' => $petugas->id_petugas,
                        'id_jenis_transaksi' => $jenisSetoran->id_jenis_transaksi,
                        'jumlah' => $saldoMasukRekening,
                        'tanggal_transaksi' => now('Asia/Jakarta'),
                        'status' => 'berhasil',
                        'keterangan' => $keteranganSetoran,
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
                    ', saldo masuk rekening Rp ' .
                    number_format($saldoMasukRekening, 0, ',', '.') . '.'
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
        $nasabah = Nasabah::findOrFail($id);

        if ($nasabah->rekening) {
            $adaTransaksi = DetailTabungan::where(
                'no_rek',
                $nasabah->rekening->no_rek
            )->exists();

            if ($adaTransaksi) {
                return redirect()
                    ->back()
                    ->with(
                        'error',
                        'Nasabah tidak dapat dihapus karena sudah memiliki transaksi tabungan.'
                    );
            }
        }

        DB::beginTransaction();

        try {
            $username = $nasabah->username;

            $nasabah->rekening()->delete();
            $nasabah->delete();

            User::where('username', $username)->delete();

            DB::commit();

            return redirect()
                ->route('operator.nasabah.index')
                ->with('success', 'Nasabah berhasil dihapus.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus nasabah: ' . $e->getMessage());
        }
    }
}