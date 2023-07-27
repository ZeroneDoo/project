<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaptisTable extends Migration
{
    public function up()
    {
        Schema::create('baptis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kkj_id')->constrained()->onDelete('cascade');
            $table->foreignId('anggota_keluarga_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamp('waktu');
            $table->string('pendeta');
            $table->string('foto')->nullable();
            $table->enum('status', ['waiting', 'done']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('baptis');
    }
}
