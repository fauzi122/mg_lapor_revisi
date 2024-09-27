<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengolahan extends Model
{
    use HasFactory;
    protected $table = 'pengolahans';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $guarded = ['id'];
}
