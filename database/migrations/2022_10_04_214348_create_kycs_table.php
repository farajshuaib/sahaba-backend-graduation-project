<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('kycs', function (Blueprint $table) {
            $table->id();
            $table->string("country", 20);
            $table->enum("gender", ['male', 'female'])->default('male');
            $table->string("city", 20);
            $table->string("address", 50);
            $table->enum("author_type", ['creator', 'collector']);
            $table->enum("status", ['on_review', 'approved', 'rejected', 'pending'])->default('on_review');
            $table->string("author_art_type", 50);
            $table->string("phone_number")->unique();
            $table->foreignId("user_id")->unique()->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('k_y_cs');
    }
};
