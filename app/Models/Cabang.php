<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Cabang extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($post) {
            $post->pendeta_cabang()->delete();
            $post->cabang_ibadah()->delete();
            $post->kegiatan()->delete();
            Storage::disk("public")->delete("$post->foto");
        });
    }

    public function pendeta_cabang ()
    {
        return $this->hasMany(PendetaCabang::class);
    }

    public function cabang_ibadah ()
    {
        return $this->hasMany(CabangIbadah::class);
    }

    public function kegiatan ()
    {
        return $this->hasMany(Kegiatan::class);
    }
}
