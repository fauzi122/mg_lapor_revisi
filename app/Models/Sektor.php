<?php

namespace App\Models;

use App\Traits\LogTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sektor extends Model
{
    use HasFactory, LogTrait;

    protected $table = 'sektors';
    protected $fillable = ['nama_sektor'];
    public $timestamps = false;
}
