<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnggotaKeluarga extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];public static function boot()
    {
        parent::boot();

        static::deleting(function ($post) {
            $post->baptiss()->delete();
            $post->penyerahan()->delete();
        });
    }

    public function kkj(){
        return $this->belongsTo(Kkj::class);
    }

    public function baptiss(){
        return $this->hasMany(Baptis::class);
    
    }
    public function penyerahan(){
        return $this->hasMany(Penyerahan::class);
    }
}
