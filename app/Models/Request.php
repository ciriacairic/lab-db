<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Request extends Model
{
    protected $guarded = [];

    protected $connection = 'mongodb';
    protected $collection = 'requests';
}
