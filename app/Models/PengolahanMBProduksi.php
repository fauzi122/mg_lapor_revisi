<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengolahanMBProduksi extends Model
{
    use HasFactory;

    protected $table = 'pengolahan_minyak_bumi_produksis';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $guarded = ['id'];
}
