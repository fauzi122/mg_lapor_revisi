<?php

namespace App\Models;

use App\Traits\LogTrait;
use App\Traits\LogTraitEv;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Negara extends Model
{
    use HasFactory, LogTrait;

    protected $table = 'negaras';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $guarded = ['id'];
}
