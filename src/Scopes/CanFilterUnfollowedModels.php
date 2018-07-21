<?php

namespace Rennokki\Befriended\Scopes;

trait CanFilterUnfollowedModels
{
    public function scopeFilterUnfollowingsOf($query, $model)
    {
        $followingIds = collect($model->following($this->getMorphClass())->get()->toArray())->pluck($model->getKeyName())->all();

        return $query->whereNotIn($this->getKeyName(), $followingIds);
    }
}
