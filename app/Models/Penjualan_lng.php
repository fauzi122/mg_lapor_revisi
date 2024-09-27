<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan_lng extends Model
{
    use HasFactory;

    protected $table = 'penjualan_lngs';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $guarded = [];
}
