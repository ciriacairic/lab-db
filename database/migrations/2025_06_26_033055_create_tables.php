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
        Schema::create('publishers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('platforms', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('developers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('type');
            $table->timestamps();
        });

        Schema::create('franchises', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->unsignedBigInteger('steam_appid')->nullable();
            $table->integer('required_age')->nullable();
            $table->boolean('is_free')->nullable();
            $table->text('detailed_description')->nullable();
            $table->text('about_the_game')->nullable();
            $table->text('short_description')->nullable();
            $table->string('header_image')->nullable();
            $table->string('capsule_image')->nullable();
            $table->string('capsule_imagev5')->nullable();
            $table->string('website')->nullable();
            $table->decimal('technical_score', 4, 2)->nullable();
            $table->decimal('subjective_score', 4, 2)->nullable();
            $table->timestamps();
        });

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
            $table->enum('status', ['active', 'banned'])->default('active');
            $table->string('role', 20)->default('common');
            $table->timestamps();
        });

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

            $table->foreignId('follower_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('followed_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->timestamps();

            $table->unique(['follower_id', 'followed_id']);
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

        Schema::create('game_platforms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_id');
            $table->unsignedBigInteger('platform_id');

            $table->date('release_date')->nullable();
            $table->date('end_service_date')->nullable();

            $table->json('metacritic')->nullable();
            $table->json('recommendations')->nullable();
            $table->json('dlc')->nullable();

            $table->unsignedBigInteger('developer_id')->nullable();
            $table->unsignedBigInteger('publisher_id')->nullable();

            $table->timestamps();

            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
            $table->foreign('platform_id')->references('id')->on('platforms')->onDelete('cascade');
            $table->foreign('developer_id')->references('id')->on('developers')->onDelete('set null');
            $table->foreign('publisher_id')->references('id')->on('publishers')->onDelete('set null');
        });

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

        Schema::create('game_tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_id');
            $table->unsignedBigInteger('tag_id');

            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publishers');
        Schema::dropIfExists('developers');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('franchises');
        Schema::dropIfExists('games');
        Schema::dropIfExists('libraries');
        Schema::dropIfExists('platforms');
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('followers');
        Schema::dropIfExists('library_games');
        Schema::dropIfExists('game_platforms');
        Schema::dropIfExists('publisher_games');
        Schema::dropIfExists('developer_games');
        Schema::dropIfExists('game_tags');
    }
};
