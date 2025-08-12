<?php

namespace App\Models;

use App\Traits\LogTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaLPG extends Model
{
    use HasFactory, LogTrait;

    protected $table = 'harga_l_p_g_s';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $guarded = ['id'];
}
