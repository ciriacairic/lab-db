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

            $table->foreignId('publisher_id')
                ->constrained('publishers')
                ->onDelete('cascade');

            $table->foreignId('game_id')
                ->constrained('games')
                ->onDelete('cascade');

            $table->timestamps();

            $table->unique(['publisher_id', 'game_id']);
        });

        Schema::create('developer_games', function (Blueprint $table) {
            $table->id();

            $table->foreignId('developer_id')
                ->constrained('developers')
                ->onDelete('cascade');

            $table->foreignId('game_id')
                ->constrained('games')
                ->onDelete('cascade');

            $table->timestamps();

            $table->unique(['developer_id', 'game_id']);
        });

        Schema::create('tag_games', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tag_id')
                ->constrained('tags')
                ->onDelete('cascade');

            $table->foreignId('game_id')
                ->constrained('games')
                ->onDelete('cascade');

            $table->timestamps();

            $table->unique(['game_id', 'tag_id']);
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
