<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKkjPasangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kkj_pasangans', function (Blueprint $table) {
            $table->id();
            $table->foreignId("kkj_id")->constrained()->onDelete("cascade");
            $table->string("nama");
            $table->enum("jk", ['L', 'P']);
            $table->string("tmpt_lahir");
            $table->date("tgl_lahir");
            $table->string("pendidikan_terakhir");
            $table->string("pekerjaan");
            $table->date("baptis");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kkj_pasangans');
    }
}
