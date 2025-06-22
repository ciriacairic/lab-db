<?php

namespace App\Models\Neo4j;
use Vinelab\NeoEloquent\Eloquent\Model as NeoModel;

class NodeDeveloper extends NeoModel
{
    protected $label = 'Developer';

    public function tags()
    {
        return $this->hasMany(NodeGame::class, 'CREATED_BY');
    }
}