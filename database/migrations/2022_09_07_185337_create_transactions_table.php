<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nft_id')->constrained();
            $table->foreignId('from')->constrained('users');
            $table->foreignId('to')->constrained('users');
            $table->unsignedDouble('price');
            $table->string('tx_hash');
            $table->enum('type', ['mint', 'set_for_sale', 'sale', 'update_price', 'cancel_sale']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_histories');
    }
};
