<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('collection_id')->unique();
            $table->string('name');
            $table->text('description');
            $table->foreignId('category_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->boolean('is_sensitive_content')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('collections');
    }
};
