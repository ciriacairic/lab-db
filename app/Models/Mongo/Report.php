<?php

namespace App\Models\Mongo;

use \MongoDB\Laravel\Eloquent\Model;

class Report extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'reports';

    protected $fillable = [
        'reported_type',
        'target_id',
        'user_id',
        'reason',
        'status'
    ];

    protected $casts = [
        'status' => 'string'
    ];
}
