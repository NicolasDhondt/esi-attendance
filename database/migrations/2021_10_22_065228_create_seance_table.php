<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seance', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('courseId');
            $table->unsignedBigInteger('teacherId');
            $table->unsignedBigInteger('groupId');
            $table->string('local');
            $table->dateTime('dateTime');
            $table->foreign('courseId')->references('id')->on('course')->onDelete('cascade');
            $table->foreign('teacherId')->references('id')->on('teacher')->onDelete('cascade');
            $table->foreign('groupId')->references('id')->on('group')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seance');
    }
}
