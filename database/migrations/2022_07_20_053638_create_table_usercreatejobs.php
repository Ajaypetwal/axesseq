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
        Schema::create('usercreatejobs', function (Blueprint $table) {
            $table->id();
            $table->string('role');
            $table->string('job_title');
            $table->string('company_name'); 
            $table->string('company_logo');
            $table->enum('job_type', ['Full Time', 'Part Time'])->default('Full Time');
            $table->string('salary_range');
            $table->string('salary_period');
            $table->string('address');
            $table->text('job_description');
            $table->string('qualification');    
            $table->boolean('is_hide')->default(0); 
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
        Schema::dropIfExists('usercreatejobs');
    }
};
