<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BphPengangkutanGas extends Model
{
    use HasFactory;
    
    protected $table = 'bph_pengangkutan_gas';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $guarded = ['id'];
}
