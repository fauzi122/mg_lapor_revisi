<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgresPembangunan extends Model
{
    use HasFactory;

    protected $table = 'progres_pembangunans';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $guarded = ['id'];
}
