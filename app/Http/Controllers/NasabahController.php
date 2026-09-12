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
    // tampil daftar nasabah di tabel
    public function index(Request $request)
    {
        $query = Nasabah::with(['user', 'rekening']);

        // search
        if ($request->filled('search')) {
            $search = $request->search;

            // Cari di tabel rekening yang berelasi dengan nasabah
            $query->whereHas('rekening', function($q) use ($search) {
                $q->where('no_rek', 'like', '%' . $search . '%');
            });
        }

        // Filter Status
        if ($request->filled('status_filter')) {
            $query->where('status', $request->status_filter);
        }

        // Hitung container 
        $totalNasabah = Nasabah::where('status', 'aktif')->count();

        $nasabahBaru = Nasabah::whereMonth('created_at', now()->month)->count();

        $totalSaldo = RekeningTabungan::sum('saldo');

        // gaskan eksekusi QUERY 
        $nasabahs = $query->orderBy('created_at', 'desc')->paginate(10);

        return view(
            'operator.nasabah.index',
            compact(
                'nasabahs',
                'totalNasabah',
                'nasabahBaru',
                'totalSaldo'
            )
        );
    }

    // tambah nasabah 
    public function create()
    {
        return view('operator.nasabah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:users,username',
            'nama' => 'required|string|max:255',
            'kategori' => 'required|in:siswa,guru',
            'prefix' => 'required|string|max:4',
            'password' => 'required|string|min:6',
            'alamat' => 'required|string',
            'saldo' => 'nullable|numeric|min:0',
            'tanggal_daftar' => 'required|date',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        DB::beginTransaction();

        try {

            $user = User::create([
                'username' => $request->username,
                'name' => $request->nama,
                'password' => Hash::make($request->password),
                'role' => 'nasabah',
            ]);

            // cek prefix nomor rekening
            $prefix = strtoupper(trim($request->prefix));

            // cek rekening terakhir berdasarkan prefix
            $lastRekening = RekeningTabungan::where('no_rek', 'like', $prefix . '%')
                ->orderBy('no_rek', 'desc')
                ->first();

            if ($lastRekening) {
                $lastNumber = (int) substr($lastRekening->no_rek, strlen($prefix));
                $nextNumber = $lastNumber + 1;
            } else {
                $nextNumber = 1;
            }

            // format nomor rekening baru 
            $noRek = $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            $nasabah = Nasabah::create([
                'username' => $request->username,
                'no_rek' => $noRek,
                'nama' => $request->nama,
                'kategori' => $request->kategori,
                'alamat' => $request->alamat,
                'tanggal_daftar' => $request->tanggal_daftar,
                'status' => $request->status,
                'photo' => null,
            ]);

            // Simpan ke tabel rek
            RekeningTabungan::create([
                'no_rek' => $noRek,
                'id_nasabah' => $nasabah->id_nasabah,
                'saldo' => $request->saldo ?? 0, 
            ]);

            // Simpan saldo awal sebagai transaksi setoran
            if (($request->saldo ?? 0) > 0) {

                $jenisTransaksi = DB::table('jenis_transaksi')
                    ->where('setoran', 'setoran')
                    ->first();

                if (!$jenisTransaksi) {
                    throw new \Exception('Jenis transaksi Setoran tidak ditemukan.');
                }

                DetailTabungan::create([
                    'no_rek' => $noRek,
                    'id_petugas' => auth()->user()->username,
                    'id_jenis_transaksi' => $jenisTransaksi->id_jenis_transaksi,
                    'jumlah' => $request->saldo,
                    'status' => 'berhasil',
                    'tanggal_transaksi' => now()->timezone('Asia/Jakarta'),
                ]);
            }

            DB::commit();

            return redirect()->route('operator.nasabah.index')
                ->with('success', 'Nasabah berhasil ditambahkan!');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->withErrors([
                    'error' => 'Gagal menambah nasabah: ' . $e->getMessage()
                ]);
        }
    }

    // edit nasabah dan update 
    public function edit(Nasabah $nasabah)
    {
        return view('operator.nasabah.edit', compact('nasabah'));
    }

    public function update(Request $request, Nasabah $nasabah)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'nullable|string|unique:users,username,' . $nasabah->username . ',username',
            'alamat' => 'nullable|string',
            'tanggal_daftar' => 'nullable|date',
            'status' => 'required|in:aktif,nonaktif',
            'reset_password' => 'nullable|boolean',
        ]);

        DB::beginTransaction();

        try {

            //  Update Data User 
            $userData = [
                'name' => $request->nama,
                'username' => $request->username,
            ];

            // Reset Password 
            if ($request->has('reset_password')) {
                $userData['password'] = Hash::make('nasabah123');
            }

            $nasabah->user->update($userData);

            // Update Data Nasabah
            $nasabah->update([
                'username' => $request->username,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'tanggal_daftar' => $request->tanggal_daftar,
                'status' => $request->status,
            ]);

            DB::commit();

            return redirect()->route('operator.nasabah.index')
                ->with('success', 'Data Nasabah berhasil diperbarui!');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->withErrors([
                    'error' => 'Gagal memperbarui data: ' . $e->getMessage()
                ]);
        }
    }

    // delete nasabah yah ok deh 
    public function destroy(Nasabah $nasabah)
    {
        $rekening = RekeningTabungan::where(
            'id_nasabah',
            $nasabah->id_nasabah
        )->first();

        if ($rekening) {
            $adaTransaksi = DetailTabungan::where(
                'no_rek',
                $rekening->no_rek
            )->exists();

            if ($adaTransaksi) {
                return redirect()
                    ->route('operator.nasabah.index')
                    ->with(
                        'error',
                        'Nasabah tidak dapat dihapus karena sudah memiliki riwayat transaksi.'
                    );
            }
        }

        DB::beginTransaction();

        try {

            // Hapus rekening
            RekeningTabungan::where(
                'id_nasabah',
                $nasabah->id_nasabah
            )->delete();

            // Hapus user
            User::where(
                'username',
                $nasabah->username
            )->delete();

            // Hapus nasabah
            $nasabah->delete();

            DB::commit();

            return redirect()
                ->route('operator.nasabah.index')
                ->with(
                    'success',
                    'Data Nasabah berhasil dihapus!'
                );

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with(
                'error',
                'Gagal menghapus nasabah: ' .
                $e->getMessage()
            );
        }
    }
}