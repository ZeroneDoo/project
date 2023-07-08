<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKkjAnaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kkj_anaks', function (Blueprint $table) {
            $table->id();
            $table->foreignId("kkj_id")->constrained()->onDelete("cascade");
            $table->string("nama");
            $table->enum("jk", ['L', 'P']);
            $table->string("tmpt_lahir");
            $table->date("tgl_lahir");
            $table->string("pendidikan");
            $table->string("pekerjaan")->nullable();
            $table->enum("diserahkan", ['Y', "T"]);
            $table->enum("baptis", ['Y', "T"]);
            $table->enum("nikah", ['Y', "T"]);
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
        Schema::dropIfExists('kkj_anaks');
    }
}
