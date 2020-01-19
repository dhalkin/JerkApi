<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Groups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('groups', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('company_id')->unsigned()->nullable();
            $table->string('name', 99);
            $table->bigInteger('direction_id')->unsigned()->nullable();
            $table->bigInteger('color_id')->unsigned()->nullable();
            $table->tinyInteger('max_person')->unsigned()->nullable();
            $table->integer('duration_min')->unsigned()->nullable();
            $table->text('about')->nullable();
        
        });
    
        Schema::table('groups', function($table) {
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('SET NULL');
        });
        Schema::table('groups', function($table) {
            $table->foreign('direction_id')
                ->references('id')
                ->on('directions')
                ->onDelete('SET NULL');
        });
        Schema::table('groups', function($table) {
            $table->foreign('color_id')
                ->references('id')
                ->on('colors')
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
        Schema::dropIfExists('groups');
    }
}
