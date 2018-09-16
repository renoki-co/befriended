<?php

namespace Rennokki\Befriended\Scopes;

use Rennokki\Befriended\Contracts\Liker;
use Rennokki\Befriended\Contracts\Liking;

trait LikeFilterable
{
    public function scopeLikedBy($query, $model)
    {
        if (! $model instanceof Liker && ! $model instanceof Liking) {
            return $query;
        }

        $likedIds = collect($model->liking($this->getMorphClass())->get()->toArray())->pluck($model->getKeyName())->all();

        return $query->whereIn($this->getKeyName(), $likedIds);
    }

    public function scopeNotLikedBy($query, $model)
    {
        if (! $model instanceof Liker && ! $model instanceof Liking) {
            return $query;
        }

        $likedIds = collect($model->liking($this->getMorphClass())->get()->toArray())->pluck($model->getKeyName())->all();

        return $query->whereNotIn($this->getKeyName(), $likedIds);
    }

    public function scopeFilterUnlikedFor($query, $model)
    {
        return $this->scopeNotLikedBy($query, $model);
    }

    public function scopeFilterLikedFor($query, $model)
    {
        return $this->scopeLikedBy($query, $model);
    }
}
