<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTestQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_test_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_test_id');
            $table->unsignedBigInteger('question_id');
            $table->unsignedTinyInteger('status');
            $table->unsignedBigInteger('question_option_id')->nullable();
            $table->boolean('is_correct')->nullable();
            $table->tinyInteger('marks_awarded')->nullable();
            $table->time('time_taken')->nullable();
            $table->timestamps();

            $table->foreign('user_test_id')
                  ->references('id')->on('user_tests')
                  ->onDelete('cascade');

            $table->foreign('question_id')
                  ->references('id')->on('questions')
                  ->onDelete('cascade');

            $table->foreign('question_option_id')
                  ->references('id')->on('question_options')
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
        Schema::dropIfExists('user_test_questions');
    }
}
