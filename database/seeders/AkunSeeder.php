<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Akun;

class AkunSeeder extends Seeder
{
    public function run(): void
    {
        Akun::insert([
            [
                'kode_akun' => '1-1100',
                'nama_akun' => 'Kas',
            ],
            [
                'kode_akun' => '1-1200',
                'nama_akun' => 'Piutang',
            ],
            [
                'kode_akun' => '2-2100',
                'nama_akun' => 'Tabungan',
            ],
            [
                'kode_akun' => '4-1100',
                'nama_akun' => 'Pendapatan Usaha',
            ],
            [
                'kode_akun' => '4-1200',
                'nama_akun' => 'Pendapatan Provisi',
            ],
            [
                'kode_akun' => '4-1300',
                'nama_akun' => 'Pendapatan Lain-lain',
            ],
        ]);
    }
}