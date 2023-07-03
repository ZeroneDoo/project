<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KkjAnak extends Model
{
    use HasFactory;
    protected $guarded = ["id"];

    public function kkj(){
        return $this->belongsTo(Kkj::class);
    }

    public function kkj_kepala_keluarga()
    {
        return $this->belongsTo(KkjKepalaKeluarga::class, "kkj_id");
    }
}
