<?php

namespace App\Services;

use App\Models\Game;

class GameService
{
    public static function getRecommendedGamesByTags($games) {
        if ($games->isEmpty()) {
            return null;
        }
        $recommendedGamesFinal = [];

        foreach ($games as $game) {
            $recommendedGames = $game->getRecommendedGames();
            foreach ($recommendedGames as $recommendedGame) {
                if (in_array($recommendedGame->id, $recommendedGamesFinal)) {
                    $recommendedGamesFinal[$recommendedGame->id] = $recommendedGamesFinal[$recommendedGame->id] + 1;
                } else {
                    $recommendedGamesFinal[$recommendedGame->id] = 1;
                }
            }
        }

        $topRecommended = collect($recommendedGamesFinal)
            ->sortDesc()
            ->take(20)
            ->keys();

        $games = Game::whereIn('id', $topRecommended)->get()->keyBy('id');

        $orderedGames = $topRecommended->map(fn($id) => $games[$id])->filter();

        return $orderedGames->values();
    }

    public static function getRecommendedGamesByPublishersAndDevelopers($games) {
        if ($games->isEmpty()) {
            return null;
        }

        $recommendedGamesFinal = [];

        foreach ($games as $game) {
            $recommendedGames = $game->getGameFromPublisherAndDeveloper();
            foreach ($recommendedGames as $recommendedGame) {
                if (in_array($recommendedGame->id, $recommendedGamesFinal)) {
                    $recommendedGamesFinal[$recommendedGame->id] = $recommendedGamesFinal[$recommendedGame->id] + 1;
                } else {
                    $recommendedGamesFinal[$recommendedGame->id] = 1;
                }
            }
        }

        $topRecommended = collect($recommendedGamesFinal)
            ->sortDesc()
            ->take(20)
            ->keys();

        $games = Game::whereIn('id', $topRecommended)->get()->keyBy('id');

        $orderedGames = $topRecommended->map(fn($id) => $games[$id])->filter();

        return $orderedGames->values();
    }


}
