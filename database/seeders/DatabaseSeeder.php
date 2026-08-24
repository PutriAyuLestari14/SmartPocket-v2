<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Petugas; // Pastikan model Petugas ada ya
use App\Models\Nasabah;
use App\Models\RekeningTabungan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. ADMIN (Login di users, data di petugas)
        $adminUser = User::firstOrCreate(['username' => 'admin123'], [
            'name' => 'Admin BMT',
            'password' => Hash::make('admin123'),
            'role' => 'admin', // <-- Role di users
        ]);
        Petugas::firstOrCreate(['id_user' => $adminUser->id], [
            'Username' => 'admin123',
            'Password' => 'admin123',
            'role' => 'admin', // <-- Role di tabel petugas
        ]);

        // 2. OPERATOR (Login di users, data di petugas)
        $operatorUser = User::firstOrCreate(['username' => 'operator123'], [
            'name' => 'Operator BMT',
            'password' => Hash::make('operator123'),
            'role' => 'operator', // <-- Role di users
        ]);
        Petugas::firstOrCreate(['id_user' => $operatorUser->id], [
            'Username' => 'operator123',
            'Password' => 'operator123',
            'role' => 'operator', // <-- Role di tabel petugas
        ]);

        // 3. NASABAH (Login di users, data di nasabah)
        $nasabahUser = User::firstOrCreate(['username' => '12345678'], [
            'name' => 'Siswa Nasabah',
            'password' => Hash::make('nasabah123'),
            'role' => 'nasabah',
        ]);
        $nasabah = Nasabah::firstOrCreate(['id_user' => $nasabahUser->id], [
            'nama' => 'Siswa Nasabah',
            'password' => 'nasabah123',
            'alamat' => 'Jl. Sekolah No. 1',
            'tanggal_daftar' => now(),
            'status' => 'aktif',
        ]);

        // 4. REKENING
        RekeningTabungan::firstOrCreate(['id_nasabah' => $nasabah->id_nasabah], [
            'no_rek' => 'RK-' . str_pad($nasabahUser->id, 4, '0', STR_PAD_LEFT),
            'saldo' => 500000,
        ]);
    }
}