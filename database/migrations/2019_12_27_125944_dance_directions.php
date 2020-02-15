<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DanceDirections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('dance_directions', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('company_id')->unsigned()->nullable();
            // preferable trainer
            $table->bigInteger('trainer_id')->unsigned()->nullable();
            $table->string('name', 99);
            $table->text('about')->nullable();
        
        });
    
        Schema::table('dance_directions', function($table) {
            $table->foreign('company_id')
                ->references('id')
                ->on('dance_companies')
                ->onDelete('SET NULL');
        });
    
        Schema::table('dance_directions', function($table) {
            $table->foreign('trainer_id')
                ->references('id')
                ->on('dance_company_users')
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
        Schema::dropIfExists('dance_directions');
    }
}
