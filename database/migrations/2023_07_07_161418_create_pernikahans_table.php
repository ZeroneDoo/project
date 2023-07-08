<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePernikahansTable extends Migration
{
    public function up()
    {
        Schema::create('pernikahans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengantin_pria_id')->onDelete('cascade');
            $table->foreignId('pengantin_wanita_id')->onDelete('cascade');
            $table->string('email');
            $table->timestamp('waktu_pernikahan');
            $table->string('tmpt_pernikahan');
            $table->string('alamat_setelah_menikah');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pernikahans');
    }
}
