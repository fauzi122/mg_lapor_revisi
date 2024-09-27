<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intake_Kilang extends Model
{
    use HasFactory;

    protected $table = 'intake_kilangs';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $guarded = ['id'];
}
