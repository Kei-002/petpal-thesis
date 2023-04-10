<?php

use Carbon\Carbon;
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
        Schema::create('consultations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pet_id')->unsigned();
            $table->foreign('pet_id')->references('id')->on('pets')
                ->onDelete('cascade');
            // $table->integer('disease_id')->unsigned();
            // $table->foreign('disease_id')->references('id')->on('diseases')
            //     ->onDelete('cascade');
            // $table->text('payment_status')->default("Unpaid");
            $table->boolean('is_reviewed')->default(false);
            // $table->text('consultation_status')->default("Not Reviewed");
            // $table->date('appointment_date')->default(Carbon::now());
            // $table->longText('description');
            $table->longText('doctor_comment')->default("");
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
        Schema::dropIfExists('consultations');
    }
};
