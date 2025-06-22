<?php

namespace App\Models\Neo4j;
use Vinelab\NeoEloquent\Eloquent\Model as NeoModel;

class NodeFranchise extends NeoModel
{
    protected $label = 'Franchise';

    public function tags()
    {
        return $this->hasMany(NodeGame::class, 'CONTAINS');
    }
}