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

    public function search(Request $request)
    {
        $search = $request->get('search_term');
        $games = Game::where('name', 'like', "%{$search}%")->select('id','name')->get();

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
        $name                 = $request->input('name', null);
        $steam_appid          = $request->input('steam_appid', null);
        $required_age         = $request->input('required_age', null);
        $is_free              = $request->input('is_free', null);
        $detailed_description = $request->input('detailed_description', null);
        $about_the_game       = $request->input('about_the_game', null);
        $short_description    = $request->input('short_description', null);
        $header_image         = $request->input('header_image', null);
        $capsule_image        = $request->input('capsule_image', null);
        $capsule_imagev5      = $request->input('capsule_imagev5', null);
        $website              = $request->input('website', null);

        try {
            $game = Game::create([
                'name'                 => $name,
                'steam_appid'          => $steam_appid,
                'required_age'         => $required_age,
                'is_free'              => $is_free,
                'detailed_description' => $detailed_description,
                'about_the_game'       => $about_the_game,
                'short_description'    => $short_description,
                'header_image'         => $header_image,
                'capsule_image'        => $capsule_image,
                'capsule_imagev5'      => $capsule_imagev5,
                'website'              => $website,
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Invalid request'], 400);
        }

        return response()->json(['success' => true, 'game_id' => $game->id], 201);
    }

    public function destroy($game_id)
    {
        $game = Game::find($game_id);
        $game->delete();
        return response()->json(['success' => true]);
    }
}
