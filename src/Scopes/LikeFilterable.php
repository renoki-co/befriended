<?php

namespace Rennokki\Befriended\Scopes;

use Rennokki\Befriended\Contracts\Liker;
use Rennokki\Befriended\Contracts\Liking;

trait LikeFilterable
{
    /**
     * Filter only records that the model liked.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLikedBy($query, $model)
    {
        if (! $model instanceof Liker && ! $model instanceof Liking) {
            return $query;
        }

        $likedIds = $model
            ->liking($this->getMorphClass())
            ->get()
            ->pluck($model->getKeyName())
            ->toArray();

        return $query->whereIn($this->getKeyName(), $likedIds);
    }

    /**
     * Filter only records that the model did not like.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotLikedBy($query, $model)
    {
        if (! $model instanceof Liker && ! $model instanceof Liking) {
            return $query;
        }

        $likedIds = $model
            ->liking($this->getMorphClass())
            ->get()
            ->pluck($model->getKeyName())
            ->toArray();

        return $query->whereNotIn($this->getKeyName(), $likedIds);
    }

    /**
     * Alias for scopeNotLikedBy.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterUnlikedFor($query, $model)
    {
        return $this->scopeNotLikedBy($query, $model);
    }

    /**
     * Alias for scopeLikedBy.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterLikedFor($query, $model)
    {
        return $this->scopeLikedBy($query, $model);
    }
}
