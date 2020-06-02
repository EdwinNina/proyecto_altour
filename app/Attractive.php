<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attractive extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
