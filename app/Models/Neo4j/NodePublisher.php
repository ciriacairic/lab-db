<?php

namespace App\Models\Neo4j;
use Vinelab\NeoEloquent\Eloquent\Model as NeoModel;

class NodePublisher extends NeoModel
{
    protected $label = 'Publisher';

    public function tags()
    {
        return $this->hasMany(NodeGame::class, 'PUBLISHED_BY');
    }
}