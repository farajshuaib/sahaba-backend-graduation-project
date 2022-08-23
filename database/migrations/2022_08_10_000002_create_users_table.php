<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained()->default(2);
            $table->foreignId('social_link_id')->nullable()->constrained();
            $table->string('username', 45)->nullable();
            $table->string('email', 45)->nullable()->unique();
            $table->string('bio')->nullable()->unique();
            $table->string('wallet_address', 45)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('banner_image', 45)->nullable();
            $table->string('profile_photo', 45)->nullable();
            $table->timestamps();
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
