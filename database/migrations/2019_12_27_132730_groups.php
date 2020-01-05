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
            $table->bigInteger('company_id')->unsigned();
            $table->string('name', 99);
            $table->bigInteger('direction_id')->unsigned();
            $table->bigInteger('color_id')->unsigned()->default(1);
            $table->tinyInteger('max_person')->unsigned()->nullable();
            $table->integer('duration_min')->unsigned()->nullable();
            $table->text('about')->nullable();
        
        });
    
        Schema::table('groups', function($table) {
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('CASCADE');
        });
        Schema::table('groups', function($table) {
            $table->foreign('direction_id')
                ->references('id')
                ->on('directions')
                ->onDelete('CASCADE');
        });
        Schema::table('groups', function($table) {
            $table->foreign('color_id')
                ->references('id')
                ->on('colors')
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
        Schema::dropIfExists('groups');
    }
}
