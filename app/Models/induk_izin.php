<?php

namespace App\Models;

use App\Traits\LogTrait;
use App\Traits\LogTraitEv;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class induk_izin extends Model
{
    use HasFactory, LogTrait;
    protected $guarded = [];
}
