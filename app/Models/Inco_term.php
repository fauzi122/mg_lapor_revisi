<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inco_term extends Model
{
    use HasFactory;

    protected $table = 'inco_terms';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $guarded = ['id'];
}
