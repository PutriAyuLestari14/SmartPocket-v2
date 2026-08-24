<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekeningTabungan extends Model
{
    protected $table = 'rekening_tabungan';
    protected $primaryKey = 'no_rek';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['no_rek', 'id_nasabah', 'saldo'];

    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class, 'id_nasabah', 'id_nasabah');
    }
}