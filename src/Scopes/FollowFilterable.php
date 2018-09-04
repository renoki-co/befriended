<?php

namespace Rennokki\Befriended\Scopes;

trait FollowFilterable
{
    public function scopeFollowedBy($query, $model)
    {
        if (! $model instanceof Followable && ! $model instanceof Following) {
            return $query;
        }

        $followingIds = collect($model->following($this->getMorphClass())->get()->toArray())->pluck($model->getKeyName())->all();

        return $query->whereIn($this->getKeyName(), $followingIds);
    }

    public function scopeUnfollowedBy($query, $model)
    {
        if (! $model instanceof Followable && ! $model instanceof Following) {
            return $query;
        }

        $followingIds = collect($model->following($this->getMorphClass())->get()->toArray())->pluck($model->getKeyName())->all();

        return $query->whereNotIn($this->getKeyName(), $followingIds);
    }

    public function scopeFilterFollowingsOf($query, $model)
    {
        return $this->scopeFollowedBy($query, $model);
    }

    public function scopeFilterUnfollowingsOf($query, $model)
    {
        return $this->scopeUnfollowedBy($query, $model);
    }
}
