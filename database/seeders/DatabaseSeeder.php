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
        $adminUser = User::firstOrCreate(['username' => 'admin123'], [
            'name' => 'Admin BMT',
            'password' => Hash::make('admin123'),
            'role' => 'admin', // <-- Role di users
        ]);

        Petugas::firstOrCreate(
            ['username' => $adminUser->username], 

            [
                'role' => 'admin',
                'nama_lengkap' => 'Bapak Ade',
            ]
        );

        $operatorUser = User::firstOrCreate(['username' => 'operator123'], [
            'name' => 'Operator BMT',
            'password' => Hash::make('operator123'),
            'role' => 'operator',
        ]);

        Petugas::firstOrCreate(
            ['username' => $operatorUser->username], 

            [
                'role' => 'operator',
                'nama_lengkap' => 'Teller BMT',
            ]
        );

        $siswaUser = User::firstOrCreate(
            ['username' => '12345678'], 
            [
                'name' => 'Siswa Nasabah',
                'password' => Hash::make('nasabah123'),
                'role' => 'nasabah'
            ]
        );

        $nasabahUser = User::firstOrCreate(['username' => '12345678'], [
            'name' => 'Siswa Nasabah',
            'password' => Hash::make('nasabah123'),
            'role' => 'nasabah',
        ]);

        $nasabah = Nasabah::firstOrCreate(
            ['username' => $siswaUser->username], 
            [
                'nama' => 'Siswa Nasabah',
                'kategori' => 'siswa',
                'alamat' => 'Jl. Sekolah No. 1',
                'tanggal_daftar' => now(),
                'status' => 'aktif',
            ]
        );

        RekeningTabungan::firstOrCreate(
            ['id_nasabah' => $nasabah->id_nasabah],
            ['no_rek' => 'RK-0001', 'saldo' => 500000]
        );
    }
}