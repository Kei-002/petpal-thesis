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
        Schema::create('groom_services', function (Blueprint $table) {

            $table->increments('id');
            $table->text('groom_name');
            $table->double('price');
            $table->text('description');
            $table->text('img_path')->default('/storage/images/default.jpg');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groom_services');
    }
};
