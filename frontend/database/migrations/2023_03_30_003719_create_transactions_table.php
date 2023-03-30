<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactioninfos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers')
                ->onDelete('cascade');
            $table->double('total_purchase');
            $table->text('payment_status')->default("Processing");
            $table->timestamps();
        });
        Schema::create('transactionlines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transactioninfo_id')->unsigned();
            $table->foreign('transactioninfo_id')->references('id')->on('transactioninfos')
                ->onDelete('cascade');
            $table->integer('pet_id')->unsigned();
            $table->foreign('pet_id')->references('id')->on('pets')
                ->onDelete('cascade');
            $table->integer('service_id')->unsigned();
            $table->foreign('service_id')->references('id')->on('services')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactioninfos');
        Schema::dropIfExists('transactionlines');
    }
};
