<?php

namespace App\Services\Neo4j;

use App\Models\Game;
use App\Models\Developer;
use App\Models\Publisher;
use App\Models\Franchise;
use App\Models\Tag;

use App\Services\Neo4j\GameNodeService;
use App\Services\Neo4j\DeveloperNodeService;
use App\Services\Neo4j\PublisherNodeService;
use App\Services\Neo4j\FranchiseNodeService;
use App\Services\Neo4j\TagNodeService;

class SQLSyncService
{
    public function __construct(
        protected GameNodeService $gameService,
        protected DeveloperNodeService $developerService,
        protected PublisherNodeService $publisherService,
        protected FranchiseNodeService $franchiseService,
        protected TagNodeService $tagService
    ) {}

    public function syncGame(Game $sqlGame): void
    {
        $this->gameService->createNode([
            'sql_game_id' => $sqlGame->id,
            'name'        => $sqlGame->name,
        ]);

        $version = $sqlGame->platformsWithDetails->first();

        if ($version?->developer_id) {
            $developer = Developer::find($version->developer_id);
            if ($developer) {
                $this->developerService->createDeveloper([
                    'sql_developer_id' => $developer->id,
                    'name' => $developer->name,
                ]);

                $this->gameService->linkDeveloper($sqlGame->id, $developer->id, $developer->name);
            }
        }

        if ($version?->publisher_id) {
            $publisher = Publisher::find($version->publisher_id);
            if ($publisher) {
                $this->publisherService->createPublisher([
                    'sql_publisher_id' => $publisher->id,
                    'name' => $publisher->name,
                ]);

                $this->gameService->linkPublisher($sqlGame->id, $publisher->id, $publisher->name);
            }
        }

        if ($sqlGame->franchise) {
            $franchise = $sqlGame->franchise;

            $this->franchiseService->createFranchise([
                'sql_franchise_id' => $franchise->id,
                'name' => $franchise->name,
            ]);

            $this->gameService->linkFranchise($sqlGame->id, $franchise->id, $franchise->name);
        }

        foreach ($sqlGame->tags as $tag) {
            $this->tagService->createTag([
                'sql_tag_id' => $tag->id,
                'name' => $tag->name,
            ]);

            $this->tagService->attachToGame($sqlGame->id, $tag->id);
        }
    }

    public function syncAllGames(): void
    {
        Game::with(['platformsWithDetails', 'franchise', 'tags'])->chunk(100, function ($games) {
            foreach ($games as $game) {
                $this->syncGame($game);
            }
        });
    }
}