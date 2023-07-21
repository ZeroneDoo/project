<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KkjKeluarga extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ["id"];

    public function kkj(){
        return $this->belongsTo(Kkj::class);
    }

    public function kkj_kepala_keluarga()
    {
        return $this->belongsTo(KkjKepalaKeluarga::class, "kkj_id");
    }
 
    public function kkj_pasangan()
    {
        return $this->belongsTo(KkjPasangan::class, "kkj_id");
    }

    public function baptiss()
    {
        return $this->hasOne(Baptis::class);
    }

    public function penyerahan()
    {
        return $this->hasOne(Penyerahan::class);
    }
}
