<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IzinUsaha extends Model
{
    use HasFactory;

    protected $table = 'izin_usaha';

    public $timestamps = false;
    protected $fillable = [
        'id_sub_page',
        'id_template',
        'jenis_izin',
        'nama_opsi',
        'id_ref',
        'jenis',
        'kategori_izin',
    ];
}
