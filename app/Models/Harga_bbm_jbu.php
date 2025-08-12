<?php

namespace App\Models;

use App\Traits\LogTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Harga_bbm_jbu extends Model
{
    use HasFactory, LogTrait;

    protected $table = 'harga_bbm_jbus';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $guarded = ['id'];
}
