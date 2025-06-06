<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Library extends BaseModel
{
    public function games()
    {
        return $this->belongsToMany(Game::class, 'library_game');
    }
}
