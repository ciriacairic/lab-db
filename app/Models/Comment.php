<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends \MongoDB\Laravel\Eloquent\Model
{
    protected $guarded = [];

    protected $connection = 'mongodb';
    protected $collection = 'comments';
}
