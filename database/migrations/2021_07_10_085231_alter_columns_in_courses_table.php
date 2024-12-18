<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnsInCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            /**
             * Change attributes for column(s).
             */
            $table->unsignedBigInteger('payout')->nullable()->change();
            $table->unsignedBigInteger('total_rating')->default(0)->change();
            $table->unsignedBigInteger('total_reviews')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            /**
             * No need to change the attributes of the column(s) back.
             */
        });
    }
}
