<?php

namespace App\Models;

class Theme extends \MongoDB\Laravel\Eloquent\Model
{
    protected $guarded = [];

    protected $connection = 'mongodb';
    protected $collection = 'themes';
}

