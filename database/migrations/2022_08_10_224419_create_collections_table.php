<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedInteger('collection_token_id')->unique();
            $table->text('description');
            $table->foreignId('category_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
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
