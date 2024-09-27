<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class province extends Model
{
    use HasFactory;

    protected $table = 'provinces';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $guarded = ['id'];
}
