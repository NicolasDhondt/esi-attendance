<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pae', function (Blueprint $table) {
            $table->unsignedBigInteger('studentId');
            $table->unsignedBigInteger('courseId');
            $table->primary(['studentId', 'courseId']);
            $table->foreign('studentId')->references('studentId')->on('student')->onDelete('cascade');
            $table->foreign('courseId')->references('id')->on('course')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pae');
    }
}
