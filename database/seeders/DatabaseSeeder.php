<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin BMT',
            'username' => 'admin123',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Petugas
        User::create([
            'name' => 'Petugas BMT',
            'username' => 'petugas123',
            'password' => Hash::make('petugas123'),
            'role' => 'petugas',
        ]);

        // Nasabah 
        User::create([
            'name' => 'Siswa Nasabah',
            'username' => '12345678', 
            'password' => Hash::make('nasabah123'),
            'role' => 'nasabah',
        ]);
    }
}