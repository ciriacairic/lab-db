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
    Schema::create('game_platform', function (Blueprint $table) {
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
  }

  public function down(): void
  {
      Schema::dropIfExists('game_platform');
  }
};
