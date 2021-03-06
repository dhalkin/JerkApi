<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DanceCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dance_companies', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('uid', 32)->unique();
            $table->string('name', 96);
            $table->string('city', 96)->nullable();
            $table->string('country', 96)->nullable();
            $table->string('zip',15)->nullable();
            $table->string('address',96)->nullable();
            $table->string('timezone', 96)->nullable();
            $table->text('about')->nullable();
            $table->tinyInteger('last_call_hours')->nullable();
            $table->tinyInteger('refuse_in_hours')->nullable();
            $table->text('rules')->nullable();
            $table->boolean('public_available')->default(false);
            $table->timestamps();

        });

        Schema::table('dance_companies', function($table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('dance_companies');
    }
}
