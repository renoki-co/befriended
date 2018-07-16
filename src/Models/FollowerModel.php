<?php

namespace Rennokki\Befriended\Models;

use Illuminate\Database\Eloquent\Model;

class FollowerModel extends Model
{
    protected $table = 'followers';
    protected $fillable = [
        'followable_id', 'followable_type',
        'follower_id', 'follower_type',
    ];

    public function followable()
    {
        return $this->morphTo();
    }

    public function follower()
    {
        return $this->morphTo();
    }
}
