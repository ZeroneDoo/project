<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Baptis extends Model
{
    use HasFactory;

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
