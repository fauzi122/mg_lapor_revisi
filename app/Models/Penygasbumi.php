<?php

namespace App\Models;

use App\Traits\LogTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penygasbumi extends Model
{
    use HasFactory, LogTrait;

    protected $table = 'penygasbumis';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $guarded = ['id'];
}
