<?php

namespace App\Models;

class Review extends \MongoDB\Laravel\Eloquent\Model
{
    protected $guarded = [];

    protected $connection = 'mongodb';
    protected $collection = 'reviews';
}
