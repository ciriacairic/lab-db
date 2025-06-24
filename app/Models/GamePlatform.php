<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Platform;
use App\Models\Game;
use App\Models\Developer;
use App\Models\Publisher;

class GamePlatform extends Model
{
    protected $table = 'game_platform';

    protected $casts = [
        'metacritic' => 'array',
        'recommendations' => 'array',
        'dlc' => 'array',
        'release_date' => 'date',
        'end_service_date' => 'date',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }

    public function developer()
    {
        return $this->belongsTo(Developer::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }
}