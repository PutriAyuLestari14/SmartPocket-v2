<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisTransaksiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jenis_transaksi')->insert([
            [
                'id_jenis_transaksi' => 1,
                'setoran' => 'setoran',
                'penarikan' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_jenis_transaksi' => 2,
                'setoran' => 'penarikan',
                'penarikan' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}