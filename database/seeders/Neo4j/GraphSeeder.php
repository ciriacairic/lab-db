<?php

use App\Models\Neo4j\NodeUser;
use App\Models\Neo4j\NodeGame;
use App\Models\Neo4j\NodeTag;
use App\Models\Neo4j\NodeDeveloper;
use App\Models\Neo4j\NodePublisher;

class GraphSeeder extends Seeder
{
    public function run()
    {
        $john = NodeUser::create(['email' => 'john@example.com']);
        $jane = NodeUser::create(['email' => 'jane@example.com']);

        $john->friends()->save($jane);

        $game = NodeGame::create(['title' => 'Elden Ring']);
        $tag = NodeTag::create(['name' => 'Open World']);
        $dev = NodeDeveloper::create(['name' => 'FromSoftware']);
        $pub = NodePublisher::create(['name' => 'Bandai Namco Entertainment']);

        $game->developer()->associate($dev);
        $game->publisher()->associate($pub);
        $game->save();

        $game->tags()->save($tag);

        $john->likedGames()->save($game);
    }
}