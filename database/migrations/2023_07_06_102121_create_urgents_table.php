<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUrgentsTable extends Migration
{
    public function up()
    {
        Schema::create('urgents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kkj_id')->constrained()->onDelete('cascade');
            $table->string('nama');
            $table->string('alamat');
            $table->string('telp');
            $table->string('hubungan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('urgents');
    }
}
