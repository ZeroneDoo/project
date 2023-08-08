<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($post) {
            $post->user()->delete();
        });
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
