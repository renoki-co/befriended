<?php

namespace Rennokki\Befriended\Traits;

use Rennokki\Befriended\Contracts\Follower;
use Rennokki\Befriended\Contracts\Following;

trait CanFollow
{
    public function following($model = null)
    {
        return $this->morphToMany(($model) ?: $this->getMorphClass(), 'follower', 'followers', 'follower_id', 'followable_id')
                    ->withPivot('followable_type')
                    ->wherePivot('followable_type', ($model) ?: $this->getMorphClass())
                    ->wherePivot('follower_type', $this->getMorphClass());
    }

    public function isFollowing($model)
    {
        if (! $model instanceof Follower && ! $model instanceof Following) {
            return false;
        }

        return (bool) ! is_null($this->following($model->getMorphClass())->find($model->getKey()));
    }

    public function follows($model)
    {
        return $this->isFollowing($model);
    }

    public function follow($model)
    {
        if (! $model instanceof Follower && ! $model instanceof Following) {
            return false;
        }

        if ($this->isFollowing($model)) {
            return false;
        }

        $this->following()->attach($this->getKey(), [
            'follower_id' => $this->getKey(),
            'followable_type' => $model->getMorphClass(),
            'followable_id' => $model->getKey(),
        ]);

        return true;
    }

    public function unfollow($model)
    {
        if (! $model instanceof Follower && ! $model instanceof Following) {
            return false;
        }

        if (! $this->isFollowing($model)) {
            return false;
        }

        return (bool) $this->following($model->getMorphClass())->detach($model->getKey());
    }
}
