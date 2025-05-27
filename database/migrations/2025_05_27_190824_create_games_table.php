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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('steam_appid')->nullable();
            $table->integer('required_age')->nullable();
            $table->boolean('is_free')->nullable();
            $table->json('dlc')->nullable();
            $table->text('detailed_description')->nullable();
            $table->text('about_the_game')->nullable();
            $table->text('short_description')->nullable();
            $table->string('header_image')->nullable();
            $table->string('capsule_image')->nullable();
            $table->string('capsule_imagev5')->nullable();
            $table->string('website')->nullable();
            $table->json('developers')->nullable();
            $table->json('publishers')->nullable();
            $table->json('platforms')->nullable();
            $table->json('metacritic')->nullable();
            $table->json('categories')->nullable();
            $table->json('genres')->nullable();
            $table->json('recommendations')->nullable();
            $table->json('release_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
