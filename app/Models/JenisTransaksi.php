<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisTransaksi extends Model
{
    protected $table = 'jenis_transaksi';
    protected $primaryKey = 'id_jenis_transaksi';
    public $incrementing = false; // Karena primary key bukan auto increment biasa (tergantung settingan DB)
    public $timestamps = true;

    protected $fillable = [
        'id_jenis_transaksi',
        'setoran',
        'penarikan',
    ];

    // Relasi ke DetailTabungan (1 Jenis Transaksi punya banyak Detail Tabungan)
    public function detailTabungan()
    {
        return $this->hasMany(DetailTabungan::class, 'id_jenis_transaksi', 'id_jenis_transaksi');
    }
}