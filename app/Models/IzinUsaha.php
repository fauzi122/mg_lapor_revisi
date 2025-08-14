<?php

namespace App\Models;

use App\Traits\LogTrait;
use App\Traits\LogTraitEv;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IzinUsaha extends Model
{
    use HasFactory, LogTrait;

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
