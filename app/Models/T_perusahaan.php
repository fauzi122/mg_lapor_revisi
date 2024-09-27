<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T_perusahaan extends Model
{
    use HasFactory;

    protected $table = 't_perusahaan';
    protected $primaryKey = 'ID_PERUSAHAAN';
    public $timestamps = true;

    // protected $guarded = ['id'];
}
