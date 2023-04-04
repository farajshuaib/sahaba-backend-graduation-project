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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string("first_name", 50)->nullable();
            $table->string("last_name", 50)->nullable();
            $table->string('username', 50)->nullable();
            $table->string('email', 50)->nullable()->unique();
            $table->string('bio', 255)->nullable();
            $table->string('wallet_address', 42)->unique();
            $table->enum('status', ['active', 'suspended'])->default('active');
            $table->string('fcm_token', 152)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
