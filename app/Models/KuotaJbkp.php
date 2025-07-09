<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuotaJbkp extends Model
{
    use HasFactory;

    protected $table = 'bph_jbkp_kuota';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $guarded = ['id'];
}
