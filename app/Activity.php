<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    public function attractive()
    {
        return $this->belongsTo(Attractive::class);
    }
}
