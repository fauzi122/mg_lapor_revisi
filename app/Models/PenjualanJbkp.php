<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanJbkp extends Model
{
    use HasFactory;
    
    protected $table = 'bph_penjualan_jbkp';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $guarded = ['id'];
}
