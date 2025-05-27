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
        Schema::create('libraries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->bigInteger('owner_id');
            $table->timestamps();
        });

        Schema::create('library_users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('library_id');
            $table->bigInteger('user_id');
            $table->timestamps();
        });

        Schema::create('library_games', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('library_id');
            $table->bigInteger('game_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libraries');
        Schema::dropIfExists('library_users');
        Schema::dropIfExists('library_games');
    }
};
