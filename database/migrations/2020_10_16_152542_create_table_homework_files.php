<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableHomeworkFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homework_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('filename');
            $table->string('mime');
            $table->string('path');
            $table->integer('size')->nullable();


            $table->unsignedInteger('student_id');
            $table->foreign('student_id', 'student_fk_1002008')->references('id')->on('users');
            $table->unsignedInteger('homework_id');
            $table->foreign('homework_id', 'homework_fk_1002149')->references('id')->on('homework');

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
        Schema::dropIfExists('homework_files');
    }
}
