<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\PseudoTypes\False_;

class CreateAttendanceTable extends Migration
{
    public function up()
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('seanceId');
            $table->unsignedBigInteger('studentId');
            $table->boolean('present')->default(0);
            $table->foreign('seanceId')->references('id')->on('seance')->onDelete('cascade');
            $table->foreign('studentId')->references('studentId')->on('student')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance');
    }
}
