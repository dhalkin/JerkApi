<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DanceHalls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dance_halls', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('unique_id', 32)->unique();
            $table->bigInteger('branch_id')->unsigned()->nullable();
            $table->string('name', 99);
           // $table->string('address')->nullable();
            $table->boolean('active')->default(true);
            $table->text('about')->nullable();
            
        });
    
        Schema::table('dance_halls', function($table) {
            $table->foreign('branch_id')
                ->references('id')
                ->on('dance_branches')
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
        Schema::dropIfExists('dance_halls');
    }
}
