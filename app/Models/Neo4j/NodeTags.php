<?php

namespace App\Models\Neo4j;
use Vinelab\NeoEloquent\Eloquent\Model as NeoModel;

class NodeTags extends NeoModel
{
    protected $label = 'Tag';

    public function tags()
    {
        return $this->hasMany(NodeGame::class, 'TAGGED_AS');
    }
}