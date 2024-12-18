<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTimeTakenColumnInPracticeTestQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('practice_test_questions', function (Blueprint $table) {
            /**
             * Change attributes for column(s).
             */
            $table->unsignedInteger('time_taken')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('practice_test_questions', function (Blueprint $table) {
            /**
             * No need to change the attributes of the column(s) back.
             */
        });
    }
}
