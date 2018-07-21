<?php

namespace Rennokki\Befriended\Traits;

use Rennokki\Befriended\Contracts\Liker;
use Rennokki\Befriended\Contracts\Liking;

trait CanLike
{
    public function liking($model = null)
    {
        return $this->morphToMany(($model) ?: $this->getMorphClass(), 'liker', 'likers', 'liker_id', 'likeable_id')
                    ->withPivot('likeable_type')
                    ->wherePivot('likeable_type', ($model) ?: $this->getMorphClass())
                    ->wherePivot('liker_type', $this->getMorphClass());
    }

    public function isLiking($model)
    {
        if (! $model instanceof Liker && ! $model instanceof Liking) {
            return false;
        }

        return (bool) ! is_null($this->liking($model->getMorphClass())->find($model->getKey()));
    }

    public function likes($model)
    {
        return $this->isLiking($model);
    }

    public function like($model)
    {
        if (! $model instanceof Liker && ! $model instanceof Liking) {
            return false;
        }

        if ($this->isLiking($model)) {
            return false;
        }

        $this->liking()->attach($this->getKey(), [
            'liker_id' => $this->getKey(),
            'likeable_type' => $model->getMorphClass(),
            'likeable_id' => $model->getKey(),
        ]);

        return true;
    }

    public function unlike($model)
    {
        if (! $model instanceof Liker && ! $model instanceof Liking) {
            return false;
        }

        if (! $this->isLiking($model)) {
            return false;
        }

        return (bool) $this->liking($model->getMorphClass())->detach($model->getKey());
    }
}
