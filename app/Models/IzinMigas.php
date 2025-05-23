<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IzinMigas extends Model
{
    protected $table = 'izin_migas';
    protected $connection = 'pgsql_migas';

    protected $fillable = [
        'npwp',
        'data_badan_usaha',
        'data_izin',
    ];

    protected $casts = [
        'data_badan_usaha' => 'array',
        'data_izin' => 'array',
    ];
}
