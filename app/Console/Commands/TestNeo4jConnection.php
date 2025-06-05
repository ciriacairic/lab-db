<?php

namespace App\Console\Commands;

use App\Models\Developer;
use App\Models\DeveloperGame;
use App\Models\Game;
use App\Models\Publisher;
use App\Models\PublisherGame;
use App\Models\Review;
use App\Models\Tag;
use App\Models\TagGame;
use app\Models\User;
use App\Models\UserUser;
use Illuminate\Console\Command;
use Laudis\Neo4j\ClientBuilder;

class TestNeo4jConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'neo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = ClientBuilder::create()
            ->withDriver('bolt', 'bolt://neo4j:7687')
            ->build();

        // Adiciona os usuários

        $users = User::all();

        foreach ($users as $user) {
            $client->run(
                'MERGE (u:User {id: $id})',
                [
                    'id' => (string) $user->id,
                ]
            );
        }

        // Adiciona a relação de qual usuário segue qual

        $userUsers = UserUser::all();

        foreach ($userUsers as $userUser) {
            $client->run(
                'MATCH (a:User {id: $followerId}), (b:User {id: $followedId})
         MERGE (a)-[:FOLLOWS]->(b)',
                [
                    'followerId' => (string) $userUser->follower_id,
                    'followedId' => (string) $userUser->followed_id,
                ]
            );
        }

        // Adiciona os jogos

        $games = Game::all();

        foreach ($games as $game) {
            $client->run(
                'MERGE (g:Game {id: $id})',
                [
                    'id' => (string) $game->id,
                ]
            );
        }

        // Adiciona as desenvolvedoras

        $developers = Developer::all();

        foreach ($developers as $developer) {
            $client->run(
                'MERGE (d:Developer {id: $id})',
                [
                    'id' => (string) $developer->id,
                ]
            );
        }

        // Adiciona a relação entre desenvolvedoras e jogos

        $developerGames = DeveloperGame::all();

        foreach ($developerGames as $developerGame) {
            $client->run(
                'MATCH (a:Developer {id: $developerId}), (b:Game {id: $gameId})
         MERGE (a)-[:DEVELOPED]->(b)',
                [
                    'developerId' => (string) $developerGame->developer_id,
                    'gameId' => (string) $developerGame->game_id,
                ]
            );
        }

        // Adiciona as publicadoras

        $publishers = Publisher::all();

        foreach ($publishers as $publisher) {
            $client->run(
                'MERGE (p:Publisher {id: $id})',
                [
                    'id' => (string) $publisher->id,
                ]
            );
        }

        // Adiciona a relação entre publicadoras e jogos

        $publisherGames = PublisherGame::all();

        foreach ($publisherGames as $publisherGame) {
            $client->run(
                'MATCH (a:Publisher {id: $publisherId}), (b:Game {id: $gameId})
         MERGE (a)-[:PUBLISHED]->(b)',
                [
                    'publisherId' => (string) $publisherGame->publisher_id,
                    'gameId' => (string) $publisherGame->game_id,
                ]
            );
        }

        // Adiciona as tags

        $tags = Tag::all();

        foreach ($tags as $tag) {
            $client->run(
                'MERGE (t:Tag {id: $id})',
                [
                    'id' => (string) $tag->id,
                ]
            );
        }

        // Adiciona a relação entre as tags e os jogos

        $gameTags = TagGame::all();

        foreach ($gameTags as $gameTag) {
            $client->run(
                'MATCH (a:Tag {id: $tagId}), (b:Game {id: $gameId})
         MERGE (a)-[:TAGGED]->(b)',
                [
                    'tagId' => (string) $gameTag->tag_id,
                    'gameId' => (string) $gameTag->game_id,
                ]
            );
        }

        // Adiciona a relação entre usuários e jogos

        $reviews = Review::all();

        foreach ($reviews as $review) {
            $client->run(
                'MATCH (a:User {id: $userId}), (b:Game {id: $gameId})
     MERGE (a)-[r:RATED]->(b)',
                [
                    'userId' => (string) $review->user_id,
                    'gameId' => (string) $review->game_id,
                ]
            );
        }
    }
}
