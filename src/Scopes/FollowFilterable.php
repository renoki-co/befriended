<?php

namespace Rennokki\Befriended\Scopes;

use Rennokki\Befriended\Contracts\Follower;
use Rennokki\Befriended\Contracts\Following;

trait FollowFilterable
{
    /**
     * Filter only records that the model followed.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
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

    /**
     * Filter only records that the model did not follow.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
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

    /**
     * Alias to scopeFollowedBy.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterFollowingsOf($query, $model)
    {
        return $this->scopeFollowedBy($query, $model);
    }

    /**
     * Alias to scopeUnfollowedBy.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterUnfollowingsOf($query, $model)
    {
        return $this->scopeUnfollowedBy($query, $model);
    }
}
