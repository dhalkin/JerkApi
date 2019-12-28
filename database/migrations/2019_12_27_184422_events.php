<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Events extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->dateTime('start');
            $table->dateTime('finish');
            $table->bigInteger('group_id')->unsigned();
            $table->bigInteger('trainer_one_id')->unsigned()->nullable();
            $table->bigInteger('trainer_two_id')->unsigned()->nullable();
            $table->bigInteger('hall_id')->unsigned();
            $table->boolean('active')->default(true);
            $table->text('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
