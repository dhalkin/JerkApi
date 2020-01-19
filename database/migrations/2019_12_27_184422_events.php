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
            $table->bigInteger('company_id')->unsigned()->nullable();
            $table->dateTime('start');
            $table->dateTime('finish');
            $table->bigInteger('group_id')->unsigned()->nullable();
            $table->bigInteger('hall_id')->unsigned()->nullable();
            // who works trainer
            $table->bigInteger('trainer_id')->unsigned()->nullable();
            $table->boolean('active')->default(true);
            $table->text('note')->nullable();
        });
    
        Schema::table('events', function($table) {
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('SET NULL');
        });
    
        Schema::table('events', function($table) {
            $table->foreign('group_id')
                ->references('id')
                ->on('groups')
                ->onDelete('SET NULL');
        });
    
        Schema::table('events', function($table) {
            $table->foreign('hall_id')
                ->references('id')
                ->on('halls')
                ->onDelete('SET NULL');
        });
        
        Schema::table('events', function($table) {
            $table->foreign('trainer_id')
                ->references('id')
                ->on('company_users')
                ->onDelete('SET NULL');
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
