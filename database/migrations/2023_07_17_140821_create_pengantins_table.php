<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengantinsTable extends Migration
{
    public function up()
    {
        Schema::create('pengantins', function (Blueprint $table) {
            $table->id();
            $table->foreignId("pernikahan_id")->onDelete('cascade');
            $table->string('nama');
            $table->timestamp('waktu_baptis')->nullable();
            $table->enum('jk_pengantin', ['Pria', "Wanita"]);
            $table->string('gereja')->nullable();
            $table->string('no_kkj')->nullable();
            $table->string('no_ktp');
            $table->string('tmpt_lahir');
            $table->date('tgl_lahir');
            $table->string('status_menikah')->nullable();
            $table->string('alamat');
            $table->string('no_telp')->nullable();
            $table->string('nama_ayah');
            $table->string('nama_ibu');
            $table->string('foto')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengantins');
    }
}
