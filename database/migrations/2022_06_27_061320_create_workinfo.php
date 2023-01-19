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
        Schema::create('workinfo', function (Blueprint $table) {
            $table->id(); 
            $table->string('user_id');
            $table->string('company_name');
            $table->string('your_role');
            $table->date('start_date'); 
            $table->date('end_date'); 
            $table->string('your_experience');
            $table->string('link_your_resume');
            $table->string('about_me');
            $table->string('image');
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
        Schema::dropIfExists('workinfo');
    }
};
