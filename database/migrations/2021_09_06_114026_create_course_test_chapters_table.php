<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseTestChaptersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_test_chapters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_test_id');
            $table->unsignedBigInteger('course_chapter_id');
            $table->unsignedBigInteger('difficulty_level_id');
            $table->unsignedTinyInteger('number_of_questions');
            $table->timestamps();

            $table->foreign('course_test_id')
                  ->references('id')->on('course_tests')
                  ->onDelete('cascade');

            $table->foreign('course_chapter_id')
                  ->references('id')->on('course_chapters')
                  ->onDelete('cascade');

            $table->foreign('difficulty_level_id')
                  ->references('id')->on('difficulty_levels')
                  ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_test_chapters');
    }
}
