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
            $table->string('gender')->nullable();
            $table->boolean('verified')->default(false);
            $table->integer('ranking')->nullable();
            $table->string('avatar')->nullable();
            $table->string('handle')->nullable();
            $table->string('description')->nullable();
            $table->string('steam_profile')->nullable();
            $table->string('birth_date');
            $table->string('status')->default('active');
            $table->string('role')->nullable();
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
