<?php

namespace Rennokki\Befriended\Traits;

trait CanBeLiked
{
    public function likers($model = null)
    {
        return $this->morphToMany(($model) ?: $this->getMorphClass(), 'likeable', 'likers', 'likeable_id', 'liker_id')
                    ->withPivot('liker_type')
                    ->wherePivot('liker_type', ($model) ?: $this->getMorphClass())
                    ->wherePivot('likeable_type', $this->getMorphClass());
    }
}
