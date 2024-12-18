<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->unsignedInteger('discount_percentage')->nullable();
            $table->unsignedInteger('discount_amount')->nullable();
            $table->unsignedInteger('maximum_discount')->nullable();
            $table->timestamp('valid_from');
            $table->timestamp('valid_till')->nullable();
            $table->unsignedBigInteger('credits_to_user_id')->nullable();
            $table->unsignedInteger('credits_to_be_given')->nullable();
            $table->timestamps();

            $table->foreign('credits_to_user_id')
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
        Schema::dropIfExists('discounts');
    }
}
