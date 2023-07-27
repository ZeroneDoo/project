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
            $table->foreignId("pernikahan_id")->constrained()->onDelete('cascade');
            $table->foreignId("anggota_keluarga_id")->nullable()->constrained()->onDelete('cascade');
            $table->string('nama')->nullable();
            $table->enum('jk', ['pria', 'wanita']);
            $table->timestamp('waktu_baptis')->nullable();
            $table->string('gereja');
            $table->string('no_kkj')->nullable();
            $table->string('no_ktp');
            $table->string('tmpt_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('status_menikah');
            $table->string('alamat');
            $table->string('no_telp');
            $table->string('nama_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengantins');
    }
}
