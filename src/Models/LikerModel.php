<?php

namespace Rennokki\Befriended\Models;

use Illuminate\Database\Eloquent\Model;

class LikerModel extends Model
{
    protected $table = 'likers';
    protected $guarded = [];

    public function likeable()
    {
        return $this->morphTo();
    }

    public function liker()
    {
        return $this->morphTo();
    }
}
