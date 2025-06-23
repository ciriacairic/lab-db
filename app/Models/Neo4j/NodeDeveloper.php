<?php

namespace App\Models\Neo4j;
use Vinelab\NeoEloquent\Eloquent\Model as NeoModel;

class NodeDeveloper extends NeoModel
{
    protected $label = 'Developer';

    protected $fillable = [
      'sql_developer_id',
      'name',
    ];

    public function developer()
    {
        return $this->hasMany(NodeGame::class, 'CREATED_BY');
    }
}