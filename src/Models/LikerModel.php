<?php

namespace Rennokki\Befriended\Models;

use Illuminate\Database\Eloquent\Model;

class LikerModel extends Model
{
    protected $table = 'likers';
    protected $fillable = [
        'likeable_id', 'likeable_type',
        'liker_id', 'liker_type',
    ];

    public function likeable()
    {
        return $this->morphTo();
    }

    public function liker()
    {
        return $this->morphTo();
    }
}
