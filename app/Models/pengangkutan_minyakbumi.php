<?php

namespace App\Models;

use App\Traits\LogTrait;
use App\Traits\SentEmailTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pengangkutan_minyakbumi extends Model
{
    use HasFactory, LogTrait, SentEmailTrait;
    protected $table = 'pengangkutan_minyakbumis';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $guarded = ['id'];

    public function setJenisModaAttribute($value)
    {
        $this->attributes['jenis_moda'] = json_encode($value);
    }

    public function getJenisModaAttribute($value)
    {
        return $this->attributes['jenis_moda'] = json_decode($value);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'npwp', 'npwp');
    }
}
