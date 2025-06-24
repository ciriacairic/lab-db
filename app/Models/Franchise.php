<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Franchise extends BaseModel
{
    protected $fillable = ['name', 'description'];

    public function games()
    {
        return $this->hasMany(Game::class);
    }
}
