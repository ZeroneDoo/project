<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pendeta extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function penyerahan(){
        return $this->hasMany(Penyerahan::class);
    }

    public function baptiss(){
        return $this->hasMany(Baptis::class);
    }
}
