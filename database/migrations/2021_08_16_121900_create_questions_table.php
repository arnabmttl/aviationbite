<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_chapter_id');
            $table->unsignedBigInteger('question_type_id');
            $table->unsignedBigInteger('difficulty_level_id');
            $table->text('title');
            $table->text('description')->nullable();
            $table->string('previous_years');
            $table->timestamps();

            $table->foreign('course_chapter_id')
                  ->references('id')->on('course_chapters')
                  ->onDelete('cascade');

            $table->foreign('question_type_id')
                  ->references('id')->on('question_types')
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
        Schema::dropIfExists('questions');
    }
}
