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
        Schema::create('user__subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('subscription_id');
            $table->string('card_id');
            $table->string('status');
            $table->string('is_subscribed');
            $table->string('stipeSubscriptionID');
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
        Schema::dropIfExists('user__subscriptions');
    }
};
