<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends BaseModel
{
    public function games()
    {
        return $this->belongsToMany(Game::class, 'game_tag');
    }
}
