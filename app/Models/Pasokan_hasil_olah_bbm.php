<?php

namespace App\Models;

use App\Traits\LogTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasokan_hasil_olah_bbm extends Model
{
    use HasFactory, LogTrait;

    protected $table = 'pasokan_hasil_olah_bbms';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $guarded = ['id'];
}
