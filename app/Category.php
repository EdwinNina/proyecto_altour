<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function attractives()
    {
        return $this->hasMany(Attractive::class);
    }
}
