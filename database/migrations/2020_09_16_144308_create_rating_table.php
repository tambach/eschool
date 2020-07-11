<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rating', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('grade');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id', 'teacher_fk_100100149')->references('id')->on('users');
            $table->unsignedInteger('lesson_id');
            $table->foreign('lesson_id', 'lesson_fk_1001508')->references('id')->on('lessons');
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
        Schema::dropIfExists('rating');
    }
}
