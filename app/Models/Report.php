<?php

namespace App\Models;

class Report extends \MongoDB\Laravel\Eloquent\Model
{
    protected $guarded = [];

    protected $connection = 'mongodb';
    protected $collection = 'reports';
}

