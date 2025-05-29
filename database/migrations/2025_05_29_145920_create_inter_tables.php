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
        Schema::create('publisher_games', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('publisher_id');
            $table->bigInteger('game_id');
            $table->timestamps();
        });

        Schema::create('developer_games', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('developer_id');
            $table->bigInteger('game_id');
            $table->timestamps();
        });

        Schema::create('tag_games', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tag_id');
            $table->bigInteger('game_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publisher_games');
        Schema::dropIfExists('developer_games');
        Schema::dropIfExists('tag_games');
    }
};
