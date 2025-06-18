<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IzinMigasTabular extends Model
{
    protected $table = 'izin_migas_tabular';

    protected $fillable = [
        'npwp',
        'id_permohonan',
        'id_izin',
        'sub_page_id',
        'nama_tabel',
        'description',
        'data',
    ];


    protected $casts = [
        'data' => 'array',
    ];

    public $incrementing = true; // Pastikan kolom id adalah auto-increment
    protected $primaryKey = 'id'; // Primary key kolom
    protected $keyType = 'int';   // Pastikan tipe kolom id adalah integer
}
