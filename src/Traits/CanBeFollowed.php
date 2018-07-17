<?php

namespace Rennokki\Befriended\Traits;

trait CanBeFollowed
{
    public function followers($model = null)
    {
        return $this->morphToMany(($model) ?: $this->getMorphClass(), 'followable', 'followers', 'followable_id', 'follower_id')
                    ->withPivot('follower_type')
                    ->wherePivot('follower_type', ($model) ?: $this->getMorphClass())
                    ->wherePivot('followable_type', $this->getMorphClass());
    }
}
