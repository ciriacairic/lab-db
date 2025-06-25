<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nationality')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->boolean('verified')->default(false);
            $table->integer('ranking')->default(0);
            $table->string('avatar')->nullable();
            $table->string('handle')->unique();
            $table->string('description')->nullable();
            $table->string('steam_profile')->nullable();
            $table->string('birth_date');
            $table->timestamp('account_creation_date')->useCurrent();
            $table->enum('status', ['active', 'banned'])->default('active');
            $table->string('role', ['common', 'moderator', 'administrator'])->default('common');
            $table->bigInteger('theme_id')->nullable();
            $table->timestamps();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('followers', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');       
            $table->string('follower_id');  
            $table->timestamps();

            $table->foreign('user_id')->references('email')->on('users')->onDelete('cascade');
            $table->foreign('follower_id')->references('email')->on('users')->onDelete('cascade');
            $table->unique(['user_id', 'follower_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
    }
};
