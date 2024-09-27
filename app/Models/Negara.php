<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Negara extends Model
{
    use HasFactory;

    protected $table = 'negaras';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $guarded = ['id'];
}
