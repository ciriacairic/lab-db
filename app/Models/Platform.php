<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Platform extends BaseModel
{
    public function games()
    {
        return $this->belongsToMany(Game::class, 'game_platform')
                    ->withPivot([
                        'release_date', 'end_service_date',
                        'developer_id', 'publisher_id',
                        'dlc', 'metacritic', 'recommendations'
                    ])
                    ->withTimestamps();
    }
}