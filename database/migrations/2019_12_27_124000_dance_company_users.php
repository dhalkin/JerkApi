<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DanceCompanyUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dance_company_users', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('company_id')->unsigned()->nullable();
            $table->string('first_name', 96);
            $table->string('second_name', 96)->nullable();
            $table->string('phone', 12)
                ->unique()
                ->nullable()
                ->default(null);
            $table->integer('role_id')->unsigned()->nullable();
            $table->string('email', 96)
                ->unique()
                ->nullable()
                ->default(null);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 96);
            $table->string('api_token', 80)
                ->unique()
                ->nullable()
                ->default(null);
            $table->rememberToken();
            $table->boolean('active')->default(false);
            $table->text('about')->nullable();
            $table->timestamps();
        });
    
        Schema::table('dance_company_users', function($table) {
            $table->foreign('role_id')
                ->references('id')
                ->on('dance_roles')
                ->onDelete('SET NULL');
        });
    
        Schema::table('dance_company_users', function($table) {
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
        Schema::dropIfExists('dance_company_users');
    }
}
