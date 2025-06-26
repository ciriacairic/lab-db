<?php

namespace App\Models\Mongo;

use \MongoDB\Laravel\Eloquent\Model;

class Comment extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'comments';

    protected $fillable = [
        'parent_id',
        'parent_type',
        'user_id',
        'text',
        'thumbs_up',
        'thumbs_down',
        'reports'
    ];

    protected $casts = [
        'reports' => 'array',
    ];
}
