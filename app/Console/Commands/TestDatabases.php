<?php

namespace App\Console\Commands;

use App\Models\Developer;
use App\Models\DeveloperGame;
use App\Models\Game;
use App\Models\Library;
use App\Models\LibraryGame;
use App\Models\Publisher;
use App\Models\PublisherGame;
use App\Models\Tag;
use App\Models\GameTag;
use app\Models\User;
use App\Models\UserUser;
use Illuminate\Console\Command;
use Laudis\Neo4j\ClientBuilder;

class TestDatabases extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test-db';

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
        $user = User::first();

        echo 'User:';
        echo $user->toJson(JSON_PRETTY_PRINT);

        $followers = User::whereIn('id', UserUser::where('followed_id', $user->id)->pluck('follower_id'))->get();

        echo "\nSeguidores:";
        echo $followers->toJson(JSON_PRETTY_PRINT);

        $libraries = Library::where('owner_id', $user->id)->get();
        echo "\nBibliotecas:";
        echo $libraries->toJson(JSON_PRETTY_PRINT);

        $library = Library::where('name', 'Recentes')->first();
        $games = Game::whereIn('id', LibraryGame::where('library_id', $library->id)->pluck('game_id'))->select('name')->get();
        echo "\nJogos em 'Recentes':";
        echo $games->toJson(JSON_PRETTY_PRINT);

        $game = Game::where('id', 12)->first();
        echo "\nInformações Baldurs Gate:";
        echo $game->toJson(JSON_PRETTY_PRINT);

        $publishers = Publisher::whereIn('id', PublisherGame::where('game_id', $game->id)->pluck('publisher_id'))->select('name')->get();
        echo "\nPublicadoras:";
        echo $publishers->toJson(JSON_PRETTY_PRINT);

        $developers = Developer::whereIn('id', DeveloperGame::where('game_id', $game->id)->pluck('developer_id'))->select('name')->get();
        echo "\nDesenvolvedores:";
        echo $developers->toJson(JSON_PRETTY_PRINT);

        $categories = Tag::where('type', 'category')->whereIn('id', GameTag::where('game_id', $game->id)->pluck('tag_id'))->select('name')->get();
        echo "\nCategorias:";
        echo $categories->toJson(JSON_PRETTY_PRINT);

        $genres = Tag::where('type', 'genre')->whereIn('id', GameTag::where('game_id', $game->id)->pluck('tag_id'))->select('name')->get();
        echo "\nGêneros:";
        echo $genres->toJson(JSON_PRETTY_PRINT);

        $userId = $user->id;
        $client = ClientBuilder::create()
            ->withDriver('bolt', 'bolt://neo4j:7687')
            ->build();
        $gamesRatedByFollowers = $client->run(
            'MATCH (:User {id: $userId})<-[:FOLLOWS]-(follower:User)-[r:RATED]->(g:Game)
     RETURN DISTINCT g',
            ['userId' => (string) $userId]
        );
        echo "\nJogos que os seguidores avaliaram:";
        foreach ($gamesRatedByFollowers as $result) {
            $gameNode = $result->get('g');
            $game = Game::where('id', $gameNode->id)->select('name')->first();
            echo $game;
        }

        $user->delete();
        $libraries = Library::where('owner_id', $userId)->get();
        echo "\nBibliotecas do user após deletar apenas o user:";
        echo $libraries->toJson(JSON_PRETTY_PRINT);

        $tag = Tag::where('name', 'Action')->first();
        echo "\nTag Action:";
        echo $tag->toJson(JSON_PRETTY_PRINT);

        echo "\nTentativa de criar Tag com mesmo nome:";
        try {
            Tag::create([
                'name' => 'Action',
                'type' => 'genre',
            ]);
        } catch (\Exception $error) {
            echo $error->getMessage();
        }
    }

}
