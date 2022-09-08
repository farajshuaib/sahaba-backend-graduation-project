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
            $table->string('image_hash');
            $table->string('title');
            $table->string('description');
            $table->string('creator_address');
            $table->unsignedInteger('price');
            $table->string('status');
            $table->string('owner_address');
            $table->unsignedInteger('numberOfTransfers');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
