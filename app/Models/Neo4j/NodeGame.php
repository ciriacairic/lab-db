<?php

namespace App\Models\Neo4j;
use Vinelab\NeoEloquent\Eloquent\Model as NeoModel;

class NodeGame extends NeoModel
{
    protected $label = 'Game';

    public function tags()
    {
        return $this->hasMany(NodeTags::class, 'HAS_TAG');
    }

    public function developer()
    {
        return $this->belongsTo(NodeDeveloper::class, 'DEVELOPED_BY');
    }

    public function publisher()
    {
        return $this->belongsTo(NodePublisher::class, 'PUBLISHED_BY');
    }

    public function franchise()
    {
        return $this->belongsTo(NodeFranchise::class, 'PART_OF');
    }
}