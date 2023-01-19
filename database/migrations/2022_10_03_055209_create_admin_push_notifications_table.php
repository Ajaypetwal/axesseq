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
        Schema::create('admin_push_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->date('date');
            $table->string('title');
        //    $table->string('toall');
            $table->string('history');
            $table->string('description');
            $table->file('emoji');
            $table->file('file');
            $table->file('image');
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
        Schema::dropIfExists('admin_push_notifications');
    }
};
