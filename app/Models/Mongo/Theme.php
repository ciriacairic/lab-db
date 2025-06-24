<?php

namespace App\Models\Mongo;

use Jenssegers\Mongodb\Eloquent\Model;

class Theme extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'themes';

    protected $fillable = [
        'user_id',
        'colors',
        'font',
        'background_image'
    ];

    protected $casts = [
        'colors' => 'array',
    ];
}

