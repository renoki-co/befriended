<?php

namespace Rennokki\Befriended\Traits;

use Rennokki\Befriended\Contracts\Following;
use Rennokki\Befriended\Contracts\Followable;

trait CanFollow
{
    /**
     * Relationship for models that this model is currently following.
     *
     * @param Model $model The model types of the results.
     * @return morphToMany The relationship.
     */
    public function following($model = null)
    {
        return $this->morphToMany(($model) ?: $this->getMorphClass(), 'follower', 'followers', 'follower_id', 'followable_id')
                    ->withPivot('followable_type')
                    ->wherePivot('followable_type', ($model) ?: $this->getMorphClass())
                    ->wherePivot('follower_type', $this->getMorphClass())
                    ->withTimestamps();
    }

    /**
     * Check if the current model is following another model.
     *
     * @param Model $model The model which will be checked against.
     * @return bool
     */
    public function isFollowing($model): bool
    {
        if (! $model instanceof Followable && ! $model instanceof Following) {
            return false;
        }

        return (bool) ! is_null($this->following($model->getMorphClass())->find($model->getKey()));
    }

    /**
     * Check if the current model is following another model.
     *
     * @param Model $model The model which will be checked against.
     * @return bool
     */
    public function follows($model): bool
    {
        return $this->isFollowing($model);
    }

    /**
     * Follow a certain model.
     *
     * @param Model $model The model which will be followed.
     * @return bool
     */
    public function follow($model): bool
    {
        if (! $model instanceof Followable && ! $model instanceof Following) {
            return false;
        }

        if ($this->isFollowing($model)) {
            return false;
        }

        $this->following()->attach($model->getKey(), [
            'followable_type' => $model->getMorphClass(),
        ]);

        return true;
    }

    /**
     * Unfollow a certain model.
     *
     * @param Model $model The model which will be unfollowed.
     * @return bool
     */
    public function unfollow($model): bool
    {
        if (! $model instanceof Followable && ! $model instanceof Following) {
            return false;
        }

        if (! $this->isFollowing($model)) {
            return false;
        }

        return (bool) $this->following($model->getMorphClass())->detach($model->getKey());
    }
}
