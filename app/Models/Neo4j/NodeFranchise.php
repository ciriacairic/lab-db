<?php

namespace App\Models\Neo4j;
use Vinelab\NeoEloquent\Eloquent\Model as NeoModel;

class NodeFranchise extends NeoModel
{
    protected $label = 'Franchise';

    protected $fillable = [
        'sql_franchise_id',
        'name',
    ];

    public function franchise()
    {
        return $this->hasMany(NodeGame::class, 'CONTAINS');
    }
}