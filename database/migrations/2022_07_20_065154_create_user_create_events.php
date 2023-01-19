<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_create_events', function (Blueprint $table) {
            $table->id();
            $table->string('role');
            $table->string('event_title'); 
            $table->string('company_logo');
            $table->text('job_description'); 
            $table->string('attendees');
            $table->date('date'); 
            $table->string('address'); 
            $table->integer('is_hide')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_create_events');
    }
};
