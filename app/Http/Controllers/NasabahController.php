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
        $query = DB::table('v_data_lengkap_nasabah');

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

        $nasabahs = $query->orderBy('id_nasabah', 'desc')
            ->paginate(10)
            ->withQueryString();

        $ringkasan = DB::select('CALL sp_ringkasan_nasabah()');
        
        $totalNasabah = $ringkasan[0]->total_semua ?? 0;
        $nasabahAktif = $ringkasan[0]->total_aktif ?? 0;
        $nasabahNonaktif = $totalNasabah - $nasabahAktif;
        $totalSaldo = $ringkasan[0]->total_uang_beredar ?? 0;

        $nasabahBaru = Nasabah::whereMonth('tanggal_daftar', now()->month)
            ->whereYear('tanggal_daftar', now()->year)
            ->count();

        return view('operator.nasabah.index', compact(
            'nasabahs', 'totalNasabah', 'nasabahAktif', 'nasabahNonaktif', 'nasabahBaru', 'totalSaldo'
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
        'username.unique' => 'NISN / NIP ini sudah terdaftar. Gunakan nomor lain.',
        'nama.required' => 'Nama lengkap wajib diisi.',
        'kategori.required' => 'Jenis nasabah wajib dipilih.',
        'prefix.required' => 'No. Rekening (prefix) wajib diisi.',
        'saldo.numeric' => 'Saldo awal harus berupa angka.',
        'saldo.min' => 'Saldo awal tidak boleh negatif.',
        'tanggal_daftar.required' => 'Tanggal daftar wajib diisi.',
        'status.required' => 'Status wajib dipilih.',
        'password.min' => 'Password minimal 6 karakter.',
        'buku_tabungan.required' => 'Pilihan buku tabungan wajib dipilih.',
    ]);

    DB::beginTransaction();

    try {
        $saldoAwal = (int) ($request->saldo ?? 0);
        $biayaBuku = 5000;
        $pilihanBuku = $request->buku_tabungan;

        $totalDibayarNasabah = $saldoAwal;
        $saldoAkhirRekening = $saldoAwal;

        // 1. HITUNG SALDO AKHIR & TOTAL BAYAR BERDASARKAN PILIHAN BUKU
        if ($pilihanBuku === 'terpisah') {
            // Terpisah: Biaya buku DITAMBAH ke total bayar, TIDAK mengurangi saldo
            $totalDibayarNasabah = $saldoAwal + $biayaBuku;
            $saldoAkhirRekening = $saldoAwal; // SALDO TETAP UTUH
        }

        if ($pilihanBuku === 'potong') {
            // Potong: Biaya buku SUDAH TERMASUK di saldo, mengurangi saldo
            if ($saldoAwal < $biayaBuku) {
                DB::rollBack();
                return redirect()->back()->withInput()->with('error', 'Saldo awal minimal Rp 5.000 jika memilih potongan biaya buku.');
            }
            $saldoAkhirRekening = $saldoAwal - $biayaBuku; // SALDO BERKURANG
        }

        // 2. GENERATE NOMOR REKENING
        $prefix = strtoupper(trim($request->prefix));
        $counter = NomorRekeningCounter::where('prefix', $prefix)->lockForUpdate()->first();

        if (!$counter) {
            $counter = NomorRekeningCounter::create([
                'prefix' => $prefix,
                'nomor_terakhir' => 0,
            ]);
        }

        $nextNumber = $counter->nomor_terakhir + 1;
        $counter->update(['nomor_terakhir' => $nextNumber]);
        $noRek = $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        // 3. BUAT DATA USER, NASABAH, DAN REKENING
        $user = User::create([
            'username' => $request->username,
            'name' => $request->nama,
            'password' => Hash::make($request->password ?? 'nasabah123'),
            'role' => 'nasabah',
        ]);

        $nasabah = Nasabah::create([
            'username' => $user->username,
            'no_rek' => $noRek,
            'nama' => $request->nama,
            'kategori' => $request->kategori,
            'alamat' => $request->alamat,
            'tanggal_daftar' => $request->tanggal_daftar,
            'status' => $request->status,
        ]);

        RekeningTabungan::create([
            'no_rek' => $noRek,
            'id_nasabah' => $nasabah->id_nasabah,
            'saldo' => $saldoAkhirRekening, 
        ]);

        // 4. CATAT TRANSAKSI DI DETAIL TABUNGAN
        $petugas = auth()->user()->petugas;
        if (!$petugas) {
            throw new \RuntimeException('Data petugas yang sedang login tidak ditemukan.');
        }

        // A. Catat Setoran Awal (Jika saldo > 0)
        if ($saldoAwal > 0) {
            $jenisSetoran = DB::table('jenis_transaksi')
                ->where(function($q) {
                    $q->whereRaw('LOWER(TRIM(setoran)) = ?', ['setoran'])
                      ->orWhere('setoran', 'Setoran');
                })
                ->first();
            
            if ($jenisSetoran) {
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

        // B. Catat Biaya Buku - LOGIKA YANG BENAR
        if ($pilihanBuku === 'terpisah') {
            // TERPISAH: TIDAK catat di detail_tabungan!
            // Biaya buku adalah pembayaran di luar rekening nasabah
            // Saldo tetap utuh = 500.000
            // (Biaya buku bisa dicatat di tabel pendapatan BMT jika perlu)
        }

        if ($pilihanBuku === 'potong') {
            // POTONG: Catat sebagai PENARIKAN di detail_tabungan
            // Ini akan mengurangi saldo dari 500.000 jadi 495.000
            $jenisBiaya = DB::table('jenis_transaksi')
                ->where(function($q) {
                    $q->whereRaw('LOWER(TRIM(penarikan)) = ?', ['penarikan'])
                      ->orWhere('penarikan', 'Penarikan');
                })
                ->first();

            // FALLBACK: Paksa pakai ID 2
            if (!$jenisBiaya) {
                $jenisBiaya = DB::table('jenis_transaksi')->find(2);
            }

            if (!$jenisBiaya) {
                throw new \RuntimeException('Gagal menemukan jenis transaksi Penarikan (ID 2) di database!');
            }

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

        DB::commit();

        $pesan = 'Nasabah berhasil ditambahkan. ';
        
        if ($pilihanBuku === 'terpisah') {
            $pesan .= 'Total dibayar: Rp ' . number_format($totalDibayarNasabah, 0, ',', '.') . ' ';
            $pesan .= '(Termasuk biaya buku Rp 5.000 terpisah). ';
            $pesan .= 'Saldo masuk rekening: Rp ' . number_format($saldoAkhirRekening, 0, ',', '.') . '.';
        } elseif ($pilihanBuku === 'potong') {
            $pesan .= 'Total dibayar: Rp ' . number_format($totalDibayarNasabah, 0, ',', '.') . '. ';
            $pesan .= 'Saldo masuk rekening: Rp ' . number_format($saldoAkhirRekening, 0, ',', '.') . ' ';
            $pesan .= '(Sudah dipotong biaya buku Rp 5.000).';
        } else {
            $pesan .= 'Saldo masuk rekening: Rp ' . number_format($saldoAkhirRekening, 0, ',', '.') . '.';
        }

        return redirect()->route('operator.nasabah.index')->with('success', $pesan);

    } catch (\Throwable $e) {
        DB::rollBack();
        return redirect()->back()->withInput()->with('error', 'Gagal menambahkan nasabah: ' . $e->getMessage());
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

            $nasabah->user->update(['name' => $request->nama]);

            if ($request->filled('password')) {
                $nasabah->user->update(['password' => Hash::make($request->password)]);
            }

            DB::commit();
            return redirect()->route('operator.nasabah.index')->with('success', 'Data nasabah berhasil diperbarui.');

        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui nasabah: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $nasabah = Nasabah::findOrFail($id);

        $adaTransaksi = DetailTabungan::where('no_rek', $nasabah->no_rek)->exists();

        if ($adaTransaksi) {
            return redirect()->back()->with('error', 'Nasabah tidak dapat dihapus karena sudah memiliki riwayat transaksi.');
        }

        DB::beginTransaction();

        try {
            $username = $nasabah->username;
            
            $nasabah->rekening()->delete();
            $nasabah->delete();
            User::where('username', $username)->delete();

            DB::commit();

            return redirect()->route('operator.nasabah.index')->with('success', 'Nasabah berhasil dihapus.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus nasabah: ' . $e->getMessage());
        }
    }
}