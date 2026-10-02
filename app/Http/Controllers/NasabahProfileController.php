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
    public function edit()
    {
        $user = Auth::user();

        // cari data nasabah berdasarkan username
        $nasabah = Nasabah::where('username', $user->username)->first();
        
        // ambil rekening buat nampilin saldo & no rek
        $rekening = \App\Models\RekeningTabungan::where('id_nasabah', $nasabah->id_nasabah)->first();

        // kirim ke view edit profile
        return view('nasabah.profile.edit', compact('user', 'nasabah', 'rekening'));
    }

    public function update(Request $request)
    {
        // ambil user & nasabah yang login
        $user = Auth::user();

        $nasabah = Nasabah::where('username', $user->username)->firstOrFail();

        // yang boleh diubah hanya alamat dan foto
        $validated = $request->validate([
            'alamat' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // UPDATE ALAMAT
        $nasabah->alamat = $validated['alamat'];

        // UPDATE FOTO JIKA ADA
        if ($request->hasFile('photo')) {

            // hapus foto lama
            if ($nasabah->photo && Storage::disk('public')->exists($nasabah->photo)) {
                Storage::disk('public')->delete($nasabah->photo);
            }

            // simpan foto baru
            $path = $request->file('photo')->store('photos/nasabah', 'public');

            $nasabah->photo = $path;
        }

        // simpan perubahan
        $nasabah->save();

        return redirect()
            ->route('nasabah.profile.edit')
            ->with('success', 'Profile berhasil diperbarui!');
    }

    // halaman ubah password
    public function editPassword()
    {
        // redirect ke profile, karena form password ada di sana
        return redirect()->route('nasabah.profile.edit');
    }

    // proses ubah password
    public function updatePassword(Request $request)
    {
        // validasi: password lama harus bener, password baru harus dikonfirmasi
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'], // cek password lama
            'password' => ['required', Password::defaults(), 'confirmed'], // password baru + konfirmasi
        ]);

        // ambil user yang login
        $user = Auth::user();

        // hash password baru, terus simpan
        $user->password = Hash::make($validated['password']);
        $user->save();

        // balikin ke halaman edit password dengan pesan sukses
        return redirect()->route('nasabah.password.edit')->with('success', 'Password berhasil diubah!');
    }
}