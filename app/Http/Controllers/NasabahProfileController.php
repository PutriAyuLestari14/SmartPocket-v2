<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class NasabahProfileController extends Controller
{
    /**
     * Tampilkan halaman edit profile nasabah
     */
    public function edit()
    {
        $user = Auth::user();
        $nasabah = Nasabah::where('username', $user->username)->first();
        
        // Ambil data rekening untuk menampilkan Saldo & No Rek
        $rekening = \App\Models\RekeningTabungan::where('id_nasabah', $nasabah->id_nasabah)->first();

        return view('nasabah.profile.edit', compact('user', 'nasabah', 'rekening'));
    }

    /**
     * Update data profile nasabah (Termasuk Upload Foto)
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $nasabah = Nasabah::where('username', $user->username)->first();

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ]);

        $nasabah->nama = $validated['nama'];
        $nasabah->alamat = $validated['alamat'];

        // Logika Upload Foto
        if ($request->hasFile('photo')) {
            // 1. Hapus foto lama kalau ada
            if ($nasabah->photo && Storage::disk('public')->exists($nasabah->photo)) {
                Storage::disk('public')->delete($nasabah->photo);
            }

            // 2. Simpan foto baru ke folder storage/app/public/photos/nasabah
            $path = $request->file('photo')->store('photos/nasabah', 'public');
            $nasabah->photo = $path;
        }

        $nasabah->save();

        return redirect()->route('nasabah.profile.edit')->with('success', 'Profile berhasil diperbarui!');
    }

    /**
     * Tampilkan halaman ubah password
     */
    public function editPassword()
    {
        // Redirect ke halaman profile karena form password sudah ada di sana
        return redirect()->route('nasabah.profile.edit');
    }

    /**
     * Proses ubah password
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'], // Cek password lama
            'password' => ['required', Password::defaults(), 'confirmed'], // Password baru & konfirmasi
        ]);

        $user = Auth::user();
        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->route('nasabah.password.edit')->with('success', 'Password berhasil diubah!');
    }
}