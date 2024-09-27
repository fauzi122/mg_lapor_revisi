<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penygasbumi extends Model
{
    use HasFactory;

    protected $table = 'penygasbumis';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $guarded = ['id'];
}
