<?php

namespace App\Models;

use App\Traits\LogTrait;
use App\Traits\SentEmailTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan_lng extends Model
{
    use HasFactory, LogTrait, SentEmailTrait;

    protected $table = 'penjualan_lngs';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $guarded = [];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'npwp', 'npwp');
    }
}
