<?php

namespace Rennokki\Befriended\Scopes;

use Rennokki\Befriended\Contracts\Follower;
use Rennokki\Befriended\Contracts\Following;

trait FollowFilterable
{
    public function scopeFollowedBy($query, $model)
    {
        if (! $model instanceof Follower && ! $model instanceof Following) {
            return $query;
        }

        $followingIds = $model
            ->following($this->getMorphClass())
            ->get()
            ->pluck($model->getKeyName())
            ->toArray();

        return $query->whereIn($this->getKeyName(), $followingIds);
    }

    public function scopeUnfollowedBy($query, $model)
    {
        if (! $model instanceof Follower && ! $model instanceof Following) {
            return $query;
        }

        $followingIds = $model
            ->following($this->getMorphClass())
            ->get()
            ->pluck($model->getKeyName())
            ->toArray();

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
