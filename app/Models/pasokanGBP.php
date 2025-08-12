<?php

namespace App\Models;

use App\Traits\LogTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pasokanGBP extends Model
{
    use HasFactory, LogTrait;

    protected $table = 'pasokan_g_b_p_s';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $guarded = ['id'];
   
}
