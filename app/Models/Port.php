<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Port extends Model
{
    use HasFactory;

    protected $table = 'ports';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $guarded = ['id'];
}
