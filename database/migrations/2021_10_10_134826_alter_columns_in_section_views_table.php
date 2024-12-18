<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnsInSectionViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('section_views', function (Blueprint $table) {
            /**
             * Remove previous column(s)
             */
            $table->dropColumn('file_name');

            /**
             * Add new column(s)
             */
            $table->text('content')->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('section_views', function (Blueprint $table) {
            /**
             * Remove newly added column(s)
             */
            $table->dropColumn('content');

            /**
             * Add previous column(s)
             */
            $table->string('file_name')->after('name');
        });
    }
}
