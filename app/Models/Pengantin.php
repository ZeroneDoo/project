<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengantin extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function anggota_keluarga(){
        return $this->belongsTo(AnggotaKeluarga::class);
    }
    public function pernikahan(){
        return $this->belongsTo(Pernikahan::class);
    }
}
