<?php

namespace App\Models;

use App\Traits\LogTrait;
use App\Traits\LogTraitEv;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory, LogTrait;

    protected $table = 'produks';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $guarded = ['id'];
}
