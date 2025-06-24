<?php

namespace App\Models\Mongo;

use Jenssegers\Mongodb\Eloquent\Model;

class Comment extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'comments';

    protected $fillable = [
        'review_id',
        'parent_comment_id',
        'user_id',
        'text',
        'thumbs_up', 'thumbs_down',
        'reports'
    ];

    protected $casts = [
        'reports' => 'array',
    ];
}