<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisTransaksi extends Model
{
    protected $table = 'jenis_transaksi';
    protected $primaryKey = 'id_jenis_transaksi';
    public $incrementing = false; // krn primary key bukan auto increment biasa ysk 
    public $timestamps = true;

    protected $fillable = [
        'id_jenis_transaksi',
        'setoran',
        'penarikan',
    ];

    public function detailTabungan()
    {
        return $this->hasMany(DetailTabungan::class, 'id_jenis_transaksi', 'id_jenis_transaksi');
    }
}