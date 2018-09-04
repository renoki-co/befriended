<?php

namespace Rennokki\Befriended\Models;

use Illuminate\Database\Eloquent\Model;

class FollowerModel extends Model
{
    protected $table = 'followers';
    protected $guarded = [];

    public function followable()
    {
        return $this->morphTo();
    }

    public function follower()
    {
        return $this->morphTo();
    }
}
