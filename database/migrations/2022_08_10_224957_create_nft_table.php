<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('nfts', function (Blueprint $table) {
            $table->id();
            $table->string('token_id')->unique();
            $table->foreignId('collection_id')->constrained();
            $table->foreignId('creator_id')->constrained('users');
            $table->foreignId('owner_id')->constrained('users');
            $table->string('file_path');
            $table->string('title');
            $table->string('description');
            $table->unsignedDecimal('price',);
            $table->enum('status', ['published', 'pending', 'canceled', 'deleted'])->default('published');
            $table->boolean('is_for_sale')->default(false);
            $table->timestamp('sale_end_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nfts');
    }
};
