<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePracticeTestChaptersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practice_test_chapters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('practice_test_id');
            $table->unsignedBigInteger('course_chapter_id');
            $table->unsignedTinyInteger('number_of_questions');
            $table->unsignedBigInteger('difficulty_level_id')->nullable();
            $table->unsignedBigInteger('question_type_id')->nullable();
            $table->timestamps();

            $table->foreign('practice_test_id')
                  ->references('id')->on('practice_tests')
                  ->onDelete('cascade');

            $table->foreign('course_chapter_id')
                  ->references('id')->on('course_chapters')
                  ->onDelete('cascade');

            $table->foreign('difficulty_level_id')
                  ->references('id')->on('difficulty_levels')
                  ->onDelete('set null');

            $table->foreign('question_type_id')
                  ->references('id')->on('question_types')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('practice_test_chapters');
    }
}
