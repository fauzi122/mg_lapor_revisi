<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BphPenjualanGasBumi extends Model
{
    use HasFactory;
    
    protected $table = 'bph_penjualan_gas_bumi';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $guarded = ['id'];
}
