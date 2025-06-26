<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Mongo\Review;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function show($game_id)
    {
        $game = Game::find($game_id);

        if (!$game) {
            return response()->json(['error' => 'Game not found'], 404);
        }

        $game->technical_score = $game->getTechnicalScoreAttribute();
        $game->subjective_score = $game->getSubjectiveScoreAttribute();

        return response()->json($game);
    }

    public function search($search_term)
    {
        $games = Game::where('name', 'like', "%{$search_term}%")->get();

        return response()->json($games);
    }

    public function reviews($game_id)
    {
        $reviews = Review::where('game_id', $game_id)->get();

        if ($reviews->isEmpty()) {
            return response()->json(['error' => 'Game not found or no reviews'], 404);
        }

        return response()->json($reviews);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        try {
            $game = Game::create($data);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Invalid request'], 400);
        }

        return response()->json(['success' => true, 'review_id' => $game->id], 201);
    }

    public function destroy($game_id)
    {
        $game = Game::find($game_id);
        $game->delete();
        return response()->json(['success' => true]);
    }
}
