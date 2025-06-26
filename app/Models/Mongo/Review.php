<?php

namespace App\Models\Mongo;

use \MongoDB\Laravel\Eloquent\Model;

class Review extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'reviews';

    protected $fillable = [
        'game_id',
        'user_id',
        'markdown_text',
        'scores',
        'comments'
    ];

    protected $casts = [
        'scores' => 'array',
    ];
}
