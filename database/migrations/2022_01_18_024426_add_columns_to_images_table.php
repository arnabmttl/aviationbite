<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('images', function (Blueprint $table) {
            /**
             * New columns added
             */
            $table->unsignedBigInteger('created_by_id')->nullable()->after('imageable_type');
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
        Schema::table('images', function (Blueprint $table) {
            /**
             * Drop foreign constraints
             */
            $table->dropForeign('images_updated_by_id_foreign');
            $table->dropForeign('images_created_by_id_foreign');

            /**
             * Remove newly added columns
             */
            $table->dropColumn('updated_by_id');
            $table->dropColumn('created_by_id');
        });
    }
}
