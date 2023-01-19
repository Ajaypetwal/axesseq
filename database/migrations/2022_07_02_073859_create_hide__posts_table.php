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
        Schema::create('hide__posts', function (Blueprint $table) {
            $table->id();
            $table->string('post_id');
            $table->string('post_user_id');
            $table->string('user_id');
            $table->tinyInteger('single_post')->default('0');
            $table->tinyInteger('all_post')->default('0');
            $table->text('all_post_ids')->nullable();
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
        Schema::dropIfExists('hide__posts');
    }
};
