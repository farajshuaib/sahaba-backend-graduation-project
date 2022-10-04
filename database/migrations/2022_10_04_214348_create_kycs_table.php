<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('kycs', function (Blueprint $table) {
            $table->id();
            $table->string("country");
            $table->enum("gender", ['male', 'female'])->default('male');
            $table->string("city");
            $table->string("address");
            $table->enum("author_type", ['creator', 'collector']);
            $table->string("author_art_type");
            $table->string("phone_number");
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
