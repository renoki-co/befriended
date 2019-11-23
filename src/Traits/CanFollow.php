<?php

namespace Rennokki\Befriended\Traits;

use Rennokki\Befriended\Contracts\Followable;
use Rennokki\Befriended\Contracts\Following;

trait CanFollow
{
    /**
     * Relationship for models that this model is currently following.
     *
     * @param  null|\Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    public function following($model = null)
    {
        $modelClass = $model ? (new $model)->getMorphClass() : $this->getMorphClass();

        return $this->morphToMany($modelClass, 'follower', 'followers', 'follower_id', 'followable_id')
                    ->withPivot('followable_type')
                    ->wherePivot('followable_type', $modelClass)
                    ->wherePivot('follower_type', $this->getMorphClass())
                    ->withTimestamps();
    }

    /**
     * Check if the current model is following another model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    public function isFollowing($model): bool
    {
        if (! $model instanceof Followable && ! $model instanceof Following) {
            return false;
        }

        return ! is_null($this->following((new $model)->getMorphClass())->find($model->getKey()));
    }

    /**
     * Check if the current model is following another model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    public function follows($model): bool
    {
        return $this->isFollowing($model);
    }

    /**
     * Follow a certain model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
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
            'followable_type' => (new $model)->getMorphClass(),
        ]);

        return true;
    }

    /**
     * Unfollow a certain model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
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

        return (bool) $this->following((new $model)->getMorphClass())->detach($model->getKey());
    }
}
