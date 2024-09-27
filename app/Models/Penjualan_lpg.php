<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan_lpg extends Model
{
    use HasFactory;

    protected $table = 'penjualan_lpgs';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $guarded = ['id'];
}
