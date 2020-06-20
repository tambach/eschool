<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeworkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homework', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description');

            $table->unsignedInteger('teacher_id');
            $table->foreign('teacher_id', 'teacher_fk_100200149')->references('id')->on('users');
            $table->unsignedInteger('lesson_id');
            $table->foreign('lesson_id', 'lesson_fk_100200508')->references('id')->on('lessons');

            $table->date('date');
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
        Schema::dropIfExists('homework');
    }
}
