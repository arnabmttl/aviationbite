<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseChapterContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_chapter_contents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('course_chapter_id');
            $table->text('content');
            $table->unsignedTinyInteger('type');
            $table->string('iframe')->nullable();
            $table->unsignedInteger('sort_order');
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
        Schema::dropIfExists('course_chapter_contents');
    }
}
