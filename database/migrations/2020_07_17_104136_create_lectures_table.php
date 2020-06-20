<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLecturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lectures', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('teacher_id');
            $table->foreign('teacher_id', 'teacher_fk_101496')->references('id')->on('users');
            $table->unsignedInteger('class_id');
            $table->foreign('class_id', 'class_fk_101508')->references('id')->on('school_classes');
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
        Schema::dropIfExists('lectures');
    }
}
