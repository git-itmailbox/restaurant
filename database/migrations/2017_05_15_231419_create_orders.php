<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_number')->nullable()->unique();
            $table->unsignedSmallInteger('payment_status_id')->default('1');
            $table->unsignedBigInteger('summ_btc');
            $table->unsignedBigInteger('paid_btc')->default('0');
            $table->unsignedBigInteger('paid_uah')->default('0');
            $table->unsignedBigInteger('summ_uah');
            $table->string('address');
            $table->text('description')->nullable();
            $table->timestamps();
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
