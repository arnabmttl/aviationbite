<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('collections', function (Blueprint $table) {
            /**
             * New columns added
             */
            $table->unsignedBigInteger('created_by_id')->nullable()->after('is_sub_section');
            $table->unsignedBigInteger('updated_by_id')->nullable()->after('created_by_id');

            /**
             * Foreign key constraint added
             */
            $table->foreign('created_by_id')
                  ->references('id')->on('users')
                  ->onDelete('set null');

            $table->foreign('updated_by_id')
                  ->references('id')->on('users')
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
        Schema::table('collections', function (Blueprint $table) {
            /**
             * Drop foreign constraints
             */
            $table->dropForeign('collections_updated_by_id_foreign');
            $table->dropForeign('collections_created_by_id_foreign');

            /**
             * Remove newly added columns
             */
            $table->dropColumn('updated_by_id');
            $table->dropColumn('created_by_id');
        });
    }
}
