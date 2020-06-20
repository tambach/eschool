<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('cover')->nullable();
            $table->string('file')->nullable();
            $table->unsignedInteger('teacher_id');
            $table->foreign('teacher_id', 'teacher_fk_1010496')->references('id')->on('users');
            $table->unsignedInteger('class_id');
            $table->foreign('class_id', 'class_fk_1010508')->references('id')->on('school_classes');
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
        Schema::dropIfExists('books');
    }
}
