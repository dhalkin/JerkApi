<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Directions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('directions', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('company_id')->unsigned();
            $table->string('name', 99);
            $table->text('about')->nullable();
        
        });
    
        Schema::table('directions', function($table) {
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('directions');
    }
}