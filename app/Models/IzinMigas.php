<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IzinMigas extends Model
{
    protected $table = 'izin_migas';

    protected $fillable = [
        'npwp',
        'data_badan_usaha',
        'data_izin',
        'status_djp',
    ];

    protected $casts = [
        'data_badan_usaha' => 'array',
        'data_izin' => 'array',
    ];

    public $incrementing = true; // Pastikan kolom id adalah auto-increment
    protected $primaryKey = 'id'; // Primary key kolom
    protected $keyType = 'int';   // Pastikan tipe kolom id adalah integer
}
