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
            $table->string('email');
            $table->timestamp('waktu_pernikahan');
            $table->string('tmpt_pernikahan');
            $table->string('alamat_setelah_menikah');
            $table->enum('status', ['waiting', 'done']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pernikahans');
    }
}
