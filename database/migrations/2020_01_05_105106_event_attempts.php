<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EventAttempts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dance_event_attempts', function (Blueprint $table) {
            $table->bigInteger('event_id')->unsigned();
            $table->bigInteger('company_user_id')->unsigned();
            $table->boolean('visited')->default(false);
            $table->timestamps();
            $table->primary(array('event_id', 'company_user_id'));
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dance_event_attempts');
    }
}
