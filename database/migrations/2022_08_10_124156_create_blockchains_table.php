<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('blockchains', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30);
            $table->string('symbol', 10);
            $table->string('rpc_url')->unique();
            $table->string('explorer_url')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('blockchains');
    }
};
