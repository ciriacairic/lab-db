<?php

namespace App\Console\Commands;

use App\Models\Game;
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
                    Game::updateOrCreate(
                        ['name' => $normalizedData['name']],
                        $normalizedData
                    );
                }
            }

        }


    }
}
