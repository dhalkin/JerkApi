<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->string('unique_id', 32)->unique();
            $table->string('name', 96);
            $table->string('city', 96)->nullable();
            $table->string('country', 96)->nullable();
            $table->string('zip',15)->nullable();
            $table->string('address',96)->nullable();
            $table->string('timezone', 96)->nullable();
            $table->text('about')->nullable();
            $table->timestamps();

        });

        Schema::table('companies', function($table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('companies');
    }
}
