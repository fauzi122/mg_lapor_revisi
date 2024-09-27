<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subsidilpg extends Model
{
    use HasFactory;

    protected $table = 'subsidilpgs';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $guarded = ['id'];
}
