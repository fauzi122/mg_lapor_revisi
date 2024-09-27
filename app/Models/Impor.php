<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Impor extends Model
{
    use HasFactory;

    protected $table = 'impors';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $guarded = ['id'];
}
