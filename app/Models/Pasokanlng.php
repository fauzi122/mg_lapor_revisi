<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasokanlng extends Model
{
    use HasFactory;

    protected $table = 'pasokanlngs';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $guarded = ['id'];
}
