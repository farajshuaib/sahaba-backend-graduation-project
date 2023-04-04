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
            $table->foreignId('creator_id')->constrained('users');
            $table->foreignId('owner_id')->constrained('users');
            $table->string('file_path', 90);
            $table->string('file_type', 20);
            $table->string('title', 50);
            $table->string('description');
            $table->unsignedDouble('price');
            $table->enum('status', ['published', 'hidden'])->default('published');
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
