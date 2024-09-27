<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pengangkutan_minyakbumi extends Model
{
    use HasFactory;
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
}
