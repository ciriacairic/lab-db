<?php

namespace App\Models\Neo4j;
use Vinelab\NeoEloquent\Eloquent\Model as NeoModel;

class NodePublisher extends NeoModel
{
    protected $label = 'Publisher';
    
    protected $fillable = [
      'sql_publisher_id',
      'name'
    ];

    public function publisher()
    {
        return $this->hasMany(NodeGame::class, 'PUBLISHED_BY');
    }
}