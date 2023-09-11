<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKkjsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kkjs', function (Blueprint $table) {
            $table->id();
            $table->string("kode")->nullable()->unique();
            $table->string("nama_kepala_keluarga");
            $table->string("email");
            $table->enum("jk", ['L', 'P']);
            $table->string("alamat");
            $table->string("rt_rw");
            $table->string("telp");
            $table->string("kecamatan");
            $table->string("kabupaten");
            $table->string("provinsi");
            $table->enum("status_menikah", ['Sudah Menikah', "Belum Menikah", "Cerai"]);
            $table->enum("status", ["waiting", "done"])->default("waiting");
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
        Schema::dropIfExists('kkjs');
    }
}
