<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengantinWanitasTable extends Migration
{
    public function up()
    {
        Schema::create('pengantin_wanitas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamp('waktu_baptis');
            $table->string('gereja');
            $table->string('no_kkj');
            $table->string('no_ktp');
            $table->string('tmpt_lahir');
            $table->date('tgl_lahir');
            $table->string('status_menikah');
            $table->string('alamat');
            $table->string('no_telp');
            $table->string('nama_ayah');
            $table->string('nama_ibu');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengantin_wanitas');
    }
}
