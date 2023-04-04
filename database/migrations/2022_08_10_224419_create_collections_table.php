<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->text('description', 255);
            $table->foreignId('category_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->boolean('is_sensitive_content')->default(0);
            $table->foreignId('blockchain_id')->constrained('blockchains');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('collections');
    }
};
