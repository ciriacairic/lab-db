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
            $table->foreignId('owner_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->timestamps();

            $table->unique(['owner_id', 'name']);
        });

        Schema::create('library_games', function (Blueprint $table) {
            $table->id();

            $table->foreignId('library_id')
                ->constrained('libraries')
                ->onDelete('cascade');

            $table->foreignId('game_id')
                ->constrained('games')
                ->onDelete('cascade');

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
