<?php

namespace App\Console\Commands;

use App\Models\Developer;
use App\Models\DeveloperGame;
use App\Models\Game;
use App\Models\Publisher;
use App\Models\PublisherGame;
use App\Models\Tag;
use App\Models\TagGame;
use App\Observers\SteamObserver;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Spatie\Crawler\Crawler;

class CrawlerSteam extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawler-steam';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Extrai dados dos jogos mais populares da Steam';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $urls = [
            "https://steamcharts.com/top",
            'https://steamcharts.com/top/p.2',
            'https://steamcharts.com/top/p.3',
            'https://steamcharts.com/top/p.4',
        ];

        $steamObserver = new SteamObserver();

        $gameIds = [];

        foreach ($urls as $url) {
            Crawler::create()
                ->setCrawlObserver($steamObserver)
                ->setMaximumDepth(0)
                ->setTotalCrawlLimit(1)
                ->startCrawling($url);

            $gameIds = array_merge($gameIds, $steamObserver->content);
        }

        foreach ($gameIds as $gameId) {
            $appId = $gameId->app_id;

            $response = Http::get("https://store.steampowered.com/api/appdetails", [
                'appids' => $appId
            ]);

            if ($response->successful()) {
                $json = $response->json();

                if (isset($json[$appId]['success']) && $json[$appId]['success'] === true) {
                    $gameData = $json[$appId]['data'];

                    $normalizedData = Game::normalizeGameData($gameData);
                    $game = Game::updateOrCreate(
                        ['name' => $normalizedData['name']],
                        $normalizedData
                    );

                    if (isset($gameData['developers'])){
                        foreach ($gameData['developers'] as $developerName) {
                            $developer = Developer::where('name', $developerName)->first();

                            if (!$developer) {
                                $developer = Developer::create([
                                    'name' => $developerName,
                                ]);
                            }

                            DeveloperGame::create([
                                'developer_id' => $developer->id,
                                'game_id' => $game->id,
                            ]);
                        }
                    }

                    if (isset($gameData['publishers'])){
                        foreach ($gameData['publishers'] as $publisherName) {
                            $publisher = Publisher::where('name', $publisherName)->first();

                            if (!$publisher) {
                                $publisher = Publisher::create([
                                    'name' => $publisherName,
                                ]);
                            }

                            PublisherGame::create([
                                'publisher_id' => $publisher->id,
                                'game_id' => $game->id,
                            ]);
                        }
                    }

                    if (isset($gameData['genres'])) {
                        foreach ($gameData['genres'] as $genreName) {
                            $tag = Tag::where('name', $genreName['description'])->where('type', 'genre')->first();

                            if (!$tag) {
                                $tag = Tag::create([
                                    'name' => $genreName['description'],
                                    'type' => 'genre',
                                ]);
                            }

                            TagGame::create([
                                'tag_id' => $tag->id,
                                'game_id' => $game->id,
                            ]);
                        }
                    }

                    if (isset($gameData['categories'])) {
                        foreach ($gameData['categories'] as $categoryName) {
                            $tag = Tag::where('name', $categoryName['description'])->where('type', 'category')->first();

                            if (!$tag) {
                                $tag = Tag::create([
                                    'name' => $genreName['description'],
                                    'type' => 'category',
                                ]);
                            }

                            TagGame::create([
                                'tag_id' => $tag->id,
                                'game_id' => $game->id,
                            ]);
                        }
                    }
                }
            }

        }


    }
}
