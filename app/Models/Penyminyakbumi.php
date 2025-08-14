<?php

namespace App\Models;

use App\Traits\LogTrait;
use App\Traits\SentEmailTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyminyakbumi extends Model
{
    use HasFactory, LogTrait, SentEmailTrait;

    protected $table = 'penyminyakbumis';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $guarded = ['id'];

    public function setJenisKomoditasAttribute($value)
    {
        $this->attributes['jenis_komoditas'] = json_encode($value);
    }

    public function getJenisKomoditasAttribute($value)
    {
        return $this->attributes['jenis_komoditas'] = json_decode($value);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'npwp', 'npwp');
    }
}
