<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('nfts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collection_id')->constrained();
            $table->string('image_url');
            $table->string('title');
            $table->string('description');
            $table->string('creator_address');
            $table->foreignId('category_id')->constrained();
            $table->unsignedDecimal('price');
            $table->enum('status',['published', 'pending', 'canceled', 'deleted']);
            $table->string('owner_address');
            $table->boolean('is_for_sale')->default(false);
            $table->date('sale_end_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nfts');
    }
};
