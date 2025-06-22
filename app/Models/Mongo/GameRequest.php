<?php

namespace App\Models\Mongo;

use Jenssegers\Mongodb\Eloquent\Model;

class GameRequest extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'game_requests';

    protected $fillable = [
        'user_id',
        'game_title',
        'justification',
        'status',
        'moderator_notes'
    ];

    protected $casts = [
        'status' => 'string'
    ];
}