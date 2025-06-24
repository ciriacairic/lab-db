<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Developer extends BaseModel
{
    protected $fillable = ['name', 'description'];

    public function gameVersions()
    {
        return $this->hasMany(GamePlatform::class);
    }
}
