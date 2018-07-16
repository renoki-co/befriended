<?php

namespace Rennokki\Befriended\Traits;

trait CanFollow
{
    public function followers($model = null)
    {
        return $this->morphToMany(($model) ?: $this->getMorphClass(), 'followable', 'followers', 'followable_id', 'follower_id')
                    ->withPivot('follower_type')
                    ->wherePivot('follower_type', ($model) ?: $this->getMorphClass())
                    ->wherePivot('followable_type', $this->getMorphClass());
    }

    public function following($model = null)
    {
        return $this->morphToMany(($model) ?: $this->getMorphClass(), 'follower', 'followers', 'follower_id', 'followable_id')
                    ->withPivot('followable_type')
                    ->wherePivot('followable_type', ($model) ?: $this->getMorphClass())
                    ->wherePivot('follower_type', $this->getMorphClass());
    }

    public function isFollowing($model)
    {
        return (bool) ! is_null($this->following($model->getMorphClass())->find($model->getKey()));
    }

    public function follow($model)
    {
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
        if (! $this->isFollowing($model)) {
            return false;
        }

        return (bool) $this->following($model->getMorphClass())->detach($model->getKey());
    }
}
