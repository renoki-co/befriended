<?php

namespace Rennokki\Befriended\Scopes;

trait CanFilterFollowers
{
    public function scopeFilterFollowingsOf($query, $model)
    {
        $followingIds = collect($model->following($this->getMorphClass())->get()->toArray())->pluck($model->getKeyName())->all();

        return $query->whereIn($this->getKeyName(), $followingIds);
    }
}
