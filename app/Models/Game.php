<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Platform;

class Game extends BaseModel
{
    protected $casts = [
        'dlc' => 'array',
        'developers' => 'array',
        'publishers' => 'array',
        'platforms' => 'array',
        'categories' => 'array',
        'genres' => 'array',
        'metacritic' => 'array',
        'recommendations' => 'array',
        'release_date' => 'array'
    ];

    public function platforms()
    {
        return $this->belongsToMany(Platform::class, 'game_platform')
                    ->withPivot([
                        'release_date', 'end_service_date',
                        'developer_id', 'publisher_id',
                        'dlc', 'metacritic', 'recommendations'
                    ])
                    ->withTimestamps();
    }

    public function platformsWithDetails()
    {
        return $this->hasMany(GamePlatform::class);
    }

    public function franchise()
    {
        return $this->belongsTo(Franchise::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'game_tag');
    }

    public function getTechnicalScoreAttribute()
    {
        $reviews = Review::where('game_id', $this->id)->get();

        if ($reviews->isEmpty()) return null;

        $technicalAverages = [];

        foreach ($reviews as $review) {
            if (!isset($review->scores)) continue;

            $filtered = collect($review->scores)->except('emotional');
            $count = $filtered->count();

            if ($count > 0) {
                $technicalAverages[] = $filtered->sum() / $count;
            }
        }

        return count($technicalAverages)
            ? round(array_sum($technicalAverages) / count($technicalAverages), 2)
            : null;
    }

    public function getSubjectiveScoreAttribute()
    {
        $reviews = Review::where('game_id', $this->id)->get();

        if ($reviews->isEmpty()) return null;

        $subjectiveAverages = [];

        foreach ($reviews as $review) {
            if (!isset($review->scores)) continue;

            $all = collect($review->scores);
            $count = $all->count();

            if ($count > 0) {
                $subjectiveAverages[] = $all->sum() / $count;
            }
        }

        return count($subjectiveAverages)
            ? round(array_sum($subjectiveAverages) / count($subjectiveAverages), 2)
            : null;
    }

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
            'platforms' => $gameData['platforms'] ?? null,
            'metacritic' => $gameData['metacritic'] ?? null,
            'recommendations' => $gameData['recommendations'] ?? null,
            'release_date' => $gameData['release_date'] ?? null,
        ];
    }
}


