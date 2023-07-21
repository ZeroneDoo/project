<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Baptis extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function kkj_anak()
    {
        return $this->belongsTo(KkjAnak::class);
    }

    public function kkj_keluarga()
    {
        return $this->belongsTo(KkjKeluarga::class);
    }
}
