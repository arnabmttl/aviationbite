<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index()->nullable();
            $table->json('user_details');
            $table->unsignedTinyInteger('payment_method')->default(1)->comment('0 for Cash, 1 for Online');
            $table->unsignedTinyInteger('payment_status')->default(0)->comment('0 for Pending, 1 for Completed, 2 for Failed');
            $table->unsignedBigInteger('amount')->default(0);
            $table->unsignedBigInteger('tax_amount')->default(0);
            $table->unsignedSmallInteger('tax_percentage')->default(0);
            $table->unsignedBigInteger('discount_id')->nullable();
            $table->unsignedBigInteger('discount_amount')->default(0);
            $table->json('discount_details')->nullable();
            $table->text('remarks')->nullable();
            $table->string('razorpay_order_id')->nullable();
            $table->string('razorpay_payment_id')->nullable();
            $table->string('razorpay_signature')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('set null');

            $table->foreign('discount_id')
                  ->references('id')->on('discounts')
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
        Schema::dropIfExists('orders');
    }
}
