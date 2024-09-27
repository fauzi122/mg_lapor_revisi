<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekspor extends Model
{
    use HasFactory;

    protected $table = 'ekspors';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $guarded = ['id'];
}
