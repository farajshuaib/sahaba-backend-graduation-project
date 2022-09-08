<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->string('name', 45);
            $table->string('description', 45);
            $table->foreignId('category_id')->constrained();
            $table->string('logo_image', 45);
            $table->string('banner_image', 45);
            $table->string('website_url', 45)->nullable();
            $table->string('facebook_url', 45)->nullable();
            $table->string('twitter_url', 45)->nullable();
            $table->string('instagram_url', 45)->nullable();
            $table->string('telegram_url', 45)->nullable();
            $table->string('payout_wallet_address', 45);
            $table->boolean('is_sensitive_content')->default(0);
//            $table->tinyInteger('creator_earnings');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('collections');
    }
};
