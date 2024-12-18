<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToCourseChapterContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_chapter_contents', function (Blueprint $table) {
            /**
             * New columns added
             */
            $table->string('name')->after('course_chapter_id');
            $table->time('duration')->after('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_chapter_contents', function (Blueprint $table) {
            /**
             * Remove newly added columns
             */
            $table->dropColumn('name');
            $table->dropColumn('duration');
        });
    }
}
