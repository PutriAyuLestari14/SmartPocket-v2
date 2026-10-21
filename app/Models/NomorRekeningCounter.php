<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NomorRekeningCounter extends Model
{
    protected $table = 'nomor_rekening_counters';

    protected $fillable = [
        'prefix',
        'nomor_terakhir',
    ];

    protected $casts = [
        'nomor_terakhir' => 'integer',
    ];
}