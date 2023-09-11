<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pernikahan extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($post) {
            $post->pengantin()->delete();
        });
    }

    public function pengantin(){
        return $this->hasMany(Pengantin::class);
    }
}
