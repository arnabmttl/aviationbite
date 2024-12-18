<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            /**
             * New columns added
             */
            $table->unsignedBigInteger('role_id')->nullable()->after('id');
            $table->string('phone_number')->unique()->after('email');
            $table->unsignedBigInteger('credits')->default(0)->after('password');
            $table->string('referral_code')->unique()->after('credits');
            $table->unsignedBigInteger('referred_by_id')->nullable()->after('referral_code');

            /**
             * Foreign key constraint added
             */
            $table->foreign('role_id')
                  ->references('id')->on('roles')
                  ->onDelete(NULL);

            $table->foreign('referred_by_id')
                  ->references('id')->on('users')
                  ->onDelete(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            /**
             * Drop index and foreign constraints
             */
            $table->dropForeign('users_referred_by_id_foreign');
            $table->dropForeign('users_role_id_foreign');

            /**
             * Remove newly added columns
             */
            $table->dropColumn('referred_by_id');
            $table->dropColumn('referral_code');
            $table->dropColumn('credits');
            $table->dropColumn('phone_number');
            $table->dropColumn('role_id');
        });
    }
}
