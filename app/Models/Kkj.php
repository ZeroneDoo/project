<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kkj extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ["id"];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($post) {
            $post->wali()->delete();
            $post->anggota_keluarga()->delete();
            $post->urgent()->delete();
        });
    }

    public function wali(){
        return $this->hasMany(Wali::class);
    }
    public function anggota_keluarga(){
        return $this->hasMany(AnggotaKeluarga::class);
    }
    public function urgent(){
        return $this->hasOne(Urgent::class);
    }
}
