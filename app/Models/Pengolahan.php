<?php

namespace App\Models;

use App\Traits\LogTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengolahan extends Model
{
    use HasFactory, LogTrait;
    protected $table = 'pengolahans';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $guarded = ['id'];
}
