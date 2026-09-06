<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Nasabah;
use App\Models\RekeningTabungan;
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
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('username', 'like', "%{$search}%");
                  });
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
        $nasabahs = $query->orderBy('nama', 'asc')->paginate(10);

        return view('operator.nasabah.index', compact('nasabahs', 'totalNasabah', 'nasabahBaru', 'totalSaldo'));
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
            'password' => 'required|string|min:6',
            'alamat' => 'required|string',
            'saldo' => 'nullable|numeric|min:0',
            'tanggal_daftar' => 'required|date',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->nama,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => 'nasabah',
            ]);

            $nasabah = Nasabah::create([
            'id_user' => $user->id,
                'nama' => $request->nama,
                'kategori' => $request->kategori,
                'alamat' => $request->alamat,
                'tanggal_daftar' => $request->tanggal_daftar,
                'status' => $request->status,
                'photo' => null,
            ]);

            // cek rekening terakhir dari database
            $lastRekening = RekeningTabungan::latest('no_rek')->first();

            if ($lastRekening) {
                $lastNumber = (int) substr($lastRekening->no_rek, 3);
                $nextNumber = $lastNumber + 1;
            } else {

                $nextNumber = 1;
            }

            // format nomor rekening baru 
            $noRek = 'RK-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            // Simpan ke tabel rek
            RekeningTabungan::create([
                'no_rek' => $noRek,
                'id_nasabah' => $nasabah->id_nasabah,
                'saldo' => $request->saldo ?? 0, 
            ]);

            DB::commit();
            
            return redirect()->route('operator.nasabah.index')
                ->with('success', 'Nasabah berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menambah nasabah: ' . $e->getMessage()]);
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
            'nama'           => 'required|string|max:255',
            'username'       => 'nullable|string|unique:users,username,' . $nasabah->id_user,
            'alamat'         => 'nullable|string',
            'tanggal_daftar' => 'nullable|date',
            'status'         => 'required|in:aktif,nonaktif',
            'reset_password' => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            //  Update Data User 
            $userData = [
                'name'     => $request->nama,
                'username' => $request->username,
            ];

            //  Reset Password 
            if ($request->has('reset_password')) {
                $userData['password'] = Hash::make('nasabah123');
            }

            $nasabah->user->update($userData);

            // Update Data Nasabah
            $nasabah->update([      
                'nama'           => $request->nama,
                'alamat'         => $request->alamat,
                'tanggal_daftar' => $request->tanggal_daftar,
                'status'         => $request->status,
            ]);

            DB::commit();

            return redirect()->route('operator.nasabah.index')
                ->with('success', 'Data Nasabah berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal memperbarui data: ' . $e->getMessage()]);
        }
    }

    // delete nasabah yah ok deh 
    public function destroy(Nasabah $nasabah)
    {
        RekeningTabungan::where('id_nasabah', $nasabah->id_nasabah)->delete();
        User::where('id', $nasabah->id_user)->delete();
        $nasabah->delete();
        return redirect()->route('operator.nasabah.index')->with('success', 'Data Nasabah berhasil dihapus!');
    }
}