<?php

namespace App\Services;

use App\Models\Game;

class GameService
{
    public static function getRecommendedGames($games) {
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
}
