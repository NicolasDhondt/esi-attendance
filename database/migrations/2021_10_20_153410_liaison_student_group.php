<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LiaisonStudentGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('liaison_student_group', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('studentId');
            $table->primary(['id', 'studentId']);
            $table->foreign('studentId')->references('studentId')->on('student')->onDelete('cascade');
            $table->foreign('id')->references('id')->on('group')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('liaison_student_group');
    }
}
