<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('weekday');
            $table->time('start');
            $table->time('end');
            $table->unsignedInteger('teacher_id');
            $table->foreign('teacher_id', 'teacher_fk_1001496')->references('id')->on('users');
            $table->unsignedInteger('class_id');
            $table->foreign('class_id', 'class_fk_1001508')->references('id')->on('school_classes');
            $table->unsignedInteger('lecture_id');
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
        Schema::dropIfExists('lessons');
    }
}
