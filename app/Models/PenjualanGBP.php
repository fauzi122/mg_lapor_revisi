<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanGBP extends Model
{
    use HasFactory;
    
    protected $table = 'penjualan_g_b_p_s';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $guarded = ['id'];
}
