<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('course_id')->index()->nullable();
            $table->unsignedBigInteger('invoice_id')->index();
            $table->unsignedBigInteger('order_item_id')->index()->nullable();
            $table->timestamp('start_from')->useCurrent();
            $table->timestamp('end_on')->nullable();
            $table->unsignedTinyInteger('status')->default(1)->comment('0 for Expired, 1 for Active, 2 for Upcoming');
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            $table->foreign('course_id')
                  ->references('id')->on('courses')
                  ->onDelete('set null');

            $table->foreign('invoice_id')
                  ->references('id')->on('invoices')
                  ->onDelete('cascade');

            $table->foreign('order_item_id')
                  ->references('id')->on('order_items')
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
        Schema::dropIfExists('user_courses');
    }
}
