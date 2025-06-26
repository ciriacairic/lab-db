<?php

namespace App\Http\Controllers;

use App\Models\Developer;
use App\Models\DeveloperGame;
use App\Models\Game;
use App\Models\GamePlatform;
use App\Models\Mongo\Review;
use App\Models\Platform;
use App\Models\Publisher;
use App\Models\PublisherGame;
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
        $developerGame = DeveloperGame::where('game_id', $game_id)->first();
        if ($developerGame) {
            $game->developer = Developer::where('id', $developerGame->developer_id)->first()->name;
        }
        $publisherGame = PublisherGame::where('game_id', $game_id)->first();
        if ($publisherGame) {
            $game->publisher = Publisher::where('id', $publisherGame->publisher_id)->first()->name;
        }
        $platformIds = GamePlatform::where('game_id', $game_id)->pluck('platform_id')->toArray();
        if ($platformIds) {
            $game->platforms = Platform::whereIn('id', $platformIds)->get()->pluck('name')->toArray();
        }

        return response()->json($game);
    }

    public function search($search_term)
    {
        $games = Game::where('name', 'like', "%{$search_term}%")->select('id','name', 'capsule_image')->get();

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
        $release_date         = $request->input('release_date', null);
        $closure_date         = $request->input('closure_date', null);
        $publisherName        = $request->input('publisher', null);
        $developerName        = $request->input('developer', null);
        $franchise            = $request->input('franchise', null);
        $platforms            = $request->input('platform', []);


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
                'release_date'         => $release_date,
                'closure_date'         => $closure_date,
                'franchise'            => $franchise,
            ]);

            if ($publisherName) {
                $publisher = Publisher::where('name', $publisherName)->first();

                if (!$publisher) {
                    $publisher = Publisher::create([
                        'name' => $publisherName,
                    ]);
                }

                PublisherGame::updateOrCreate([
                    'publisher_id' => $publisher->id,
                    'game_id' => $game->id,
                ]);
            }

            if ($developerName) {
                $developer = Developer::where('name', $developerName)->first();

                if (!$developer) {
                    $developer = Developer::create([
                        'name' => $developerName,
                    ]);
                }

                DeveloperGame::updateOrCreate([
                    'developer_id' => $developer->id,
                    'game_id' => $game->id,
                ]);
            }


            foreach($platforms as $platformName) {
                $platform = Platform::where('name', $platformName)->first();

                if (!$platform) {
                    $platform = Platform::create([
                        'name' => $platformName,
                    ]);
                }

                GamePlatform::updateOrCreate([
                    'platform_id' => $platform->id,
                    'game_id' => $game->id,
                ]);
            }


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
