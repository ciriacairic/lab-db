<?php

namespace App\Models\Neo4j;
use Vinelab\NeoEloquent\Eloquent\Model as NeoModel;

class NodeUser extends NeoModel
{
    protected $label = 'User';

    public function friends()
    {
        return $this->hasMany(self::class, 'FRIENDS_WITH');
    }

    public function likedGames()
    {
        return $this->hasMany(NodeGame::class, 'LIKED');
    }
}