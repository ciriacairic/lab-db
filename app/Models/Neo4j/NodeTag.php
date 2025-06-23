<?php

namespace App\Models\Neo4j;
use Vinelab\NeoEloquent\Eloquent\Model as NeoModel;

class NodeTag extends NeoModel
{
    protected $label = 'Tag';

    protected $fillable = [
        'sql_tag_id',
        'name', 
    ];

    public function tags()
    {
        return $this->hasMany(NodeGame::class, 'TAGGED_AS');
    }
}