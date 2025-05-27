<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $guarded = [];

    protected $casts = [
        'dlc' => 'array',
        'developers' => 'array',
        'publishers' => 'array',
        'platforms' => 'array',
        'categories' => 'array',
        'genres' => 'array',
        'metacritic' => 'array'
    ];
    public static function normalizeGameData(array $gameData): array
    {
        return [
            'name' => $gameData['name'],
            'steam_appid' => $gameData['steam_appid'] ?? null,
            'required_age' => $gameData['required_age'] ?? null,
            'is_free' => $gameData['is_free'] ?? null,
            'dlc' => $gameData['dlc'] ?? null,
            'detailed_description' => $gameData['detailed_description'] ?? null,
            'about_the_game' => $gameData['about_the_game'] ?? null,
            'short_description' => $gameData['short_description'] ?? null,
            'header_image' => $gameData['header_image'] ?? null,
            'capsule_image' => $gameData['capsule_image'] ?? null,
            'capsule_imagev5' => $gameData['capsule_imagev5'] ?? null,
            'website' => $gameData['website'] ?? null,
            'developers' => $gameData['developers'] ?? null,
            'publishers' => $gameData['publishers'] ?? null,
            'platforms' => $gameData['platforms'] ?? null,
            'metacritic' => $gameData['metacritic'] ?? null,
            'categories' => $gameData['categories'] ?? null,
            'genres' => $gameData['genres'] ?? null,
            'recommendations' => $gameData['recommendations'] ?? null,
            'release_date' => $gameData['release_date'] ?? null,
        ];
    }
}


