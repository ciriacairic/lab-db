<?php

namespace Database\Seeders\Neo4j;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Game;
use App\Models\Franchise;
use App\Models\Publisher;
use App\Models\Developer;
use App\Models\Tag;

use App\Models\Neo4j\NodeUser;
use App\Models\Neo4j\NodeGame;
use App\Models\Neo4j\NodeFranchise;
use App\Models\Neo4j\NodePublisher;
use App\Models\Neo4j\NodeDeveloper;
use App\Models\Neo4j\NodeTag;

class GraphSeeder extends Seeder
{
    public function run(): void
    {
        User::all()->each(function ($user) {
            NodeUser::firstOrCreate([
                'sql_id' => $user->email,
                'name' => $user->nome,
            ]);
        });

        Game::with(
          ['franchise', 'developer', 'publisher', 'tags']
        )->get()->each(function ($game) {

            $nodeGame = NodeGame::firstOrCreate([
                'sql_id' => $game->id,
                'name' => $game->titulo,
            ]);

            $sqlDev = $game->developer;
            if ($sqlDev) {
                $nodeDev = NodeDeveloper::firstOrCreate([
                    'sql_id' => $sqlDev->id,
                    'name' => $sqlDev->name,
                ]);
                $nodeGame->developer()->associate($nodeDev);
            }

            $sqlPub = $game->publisher;
            if ($sqlPub) {
                $nodePub = NodePublisher::firstOrCreate([
                    'sql_id' => $sqlPub->id,
                    'name' => $sqlPub->name,
                ]);
                $nodeGame->publisher()->associate($nodePub);
            }

            $sqlFranchise = $game->franchise;
            if ($sqlFranchise) {
                $nodeFranchise = NodeFranchise::firstOrCreate([
                    'sql_id' => $sqlFranchise->id,
                    'name' => $sqlFranchise->name,
                ]);
                $nodeGame->franchise()->associate($nodeFranchise);
            }

            $sqlTags = $game->tags;
            foreach ($sqlTags as $sqlTag) {
                $nodeTag = NodeTag::firstOrCreate([
                    'sql_id' => $sqlTag->id,
                    'name' => $sqlTag->name,
                ]);

                if (!$nodeGame->tags()->where('name', $nodeTag->name)->exists()) {
                    $nodeGame->tags()->save($nodeTag);
                }
            }

            $nodeGame->save();
        });
    }
}