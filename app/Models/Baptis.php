<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Baptis extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function kkj(){
        return $this->belongsTo(Kkj::class);
    }

    public function anggota_keluarga()
    {
        return $this->belongsTo(AnggotaKeluarga::class);
    }
}
