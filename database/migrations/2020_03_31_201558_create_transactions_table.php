<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reservation_id')->unsigned();
            $table->enum('status', ['success', 'error', 'cancel', 'expired'])->nullable();
            $table->string('payment_message')->nullable();
            $table->string('shopping_cart_id')->nullable();
            $table->string('approval_code')->nullable();
            $table->string('ws_pay_order_id')->nullable();
            $table->dateTime('transaction_date_time')->nullable();
            $table->string('ECI')->nullable();
            $table->string('STAN')->nullable();
            $table->string('payment_partner')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('payment_card')->nullable();
            $table->string('payment_plan')->nullable();
            $table->string('credit_card_number')->nullable();
            $table->string('ws_pay_signature')->nullable();
            $table->string('currency')->nullable();
            $table->string('exchange_rate')->nullable();
            $table->integer('price')->nullable();
            $table->timestamps();
            $table->foreign('reservation_id')->references('id')->on('reservetion')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
