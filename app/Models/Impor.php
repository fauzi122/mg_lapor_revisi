<?php

namespace App\Models;

use App\Traits\LogTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Impor extends Model
{
    use HasFactory, LogTrait;

    protected $table = 'impors';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $guarded = ['id'];
}
