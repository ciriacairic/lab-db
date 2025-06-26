<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Library;
use App\Models\LibraryGame;
use app\Models\User;
use App\Services\GameService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index($user_id)
    {
        $user = User::find($user_id);

        $gamesFromFollowedUsers = $user->getGamesFromFollowedUsers();

        $favLib = Library::where('name', 'Favoritos')->where('owner_id', $user_id)->first();
        $gameIds = LibraryGame::where('library_id', $favLib->id)->pluck('game_id')->toArray();
        $games = Game::whereIn('id', $gameIds)->get();
        $gamesFromFavorites = GameService::getRecommendedGamesByTags($games);

        $playedLib = Library::where('name', 'Jogados')->where('owner_id', $user_id)->first();
        $gameIds = LibraryGame::where('library_id', $playedLib->id)->pluck('game_id')->toArray();
        $games = Game::whereIn('id', $gameIds)->get();
        $gamesFromPlayed = GameService::getRecommendedGamesByPublishersAndDevelopers($games);

        return response()->json([
            'gamesFromFollowedUsers' => $gamesFromFollowedUsers,
            'gamesFromFavorites' => $gamesFromFavorites,
            'gamesFromPlayed' => $gamesFromPlayed,
        ]);
    }
}
