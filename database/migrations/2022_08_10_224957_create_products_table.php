<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collection_id')->constrained();
            $table->string('image_url', 45);
            $table->string('image_hash', 45);
            $table->string('title', 45);
            $table->string('description', 45);
            $table->string('creator_address', 45);
            $table->string('price', 45);
            $table->string('status', 45);
            $table->string('owner_address', 45);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
