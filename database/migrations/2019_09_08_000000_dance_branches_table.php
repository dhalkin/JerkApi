<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DanceBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dance_branches', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('uid', 32)->unique();
            $table->integer('company_id')->unsigned()->nullable();
            $table->string('name', 99);
            $table->string('address');
            $table->boolean('active')->default(true);
            $table->text('about')->nullable();
        });
        
        Schema::table('dance_branches', function($table) {
            $table->foreign('company_id')
                ->references('id')
                ->on('dance_companies')
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
        Schema::dropIfExists('dance_branches');
    }
}
