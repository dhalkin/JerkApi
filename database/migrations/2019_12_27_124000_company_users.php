<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CompanyUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_users', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('company_id')->unsigned();
            $table->string('first_name', 96);
            $table->string('second_name', 96)->nullable();
            $table->string('phone', 36)
                ->unique()
                ->nullable()
                ->default(null);
            $table->tinyInteger('role_id')->unsigned()->nullable();
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
            $table->timestamps();
        });
    
        Schema::table('company_users', function($table) {
            $table->foreign('role_id')
                ->references('id')
                ->on('roles_company_users')
                ->onDelete('CASCADE');
        });
    
        Schema::table('company_users', function($table) {
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
        Schema::dropIfExists('company_users');
    }
}
