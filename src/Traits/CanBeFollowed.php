<?php

namespace Rennokki\Befriended\Traits;

use Rennokki\Befriended\Contracts\Followable;
use Rennokki\Befriended\Contracts\Following;

trait CanBeFollowed
{
    /**
     * Relationship for models that followed this model.
     *
     * @param  null|\Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    public function followers($model = null)
    {
        $modelClass = $model ? (new $model)->getMorphClass() : $this->getMorphClass();

        return $this->morphToMany($modelClass, 'followable', 'followers', 'followable_id', 'follower_id')
                    ->withPivot(['follower_type', 'accepted'])
                    ->wherePivot('follower_type', $modelClass)
                    ->wherePivot('followable_type', $this->getMorphClass())
                    ->wherePivot('accepted', true)
                    ->withTimestamps();
    }

    /**
     * Relationship for models that has requested to follow this model.
     *
     * @param  null|\Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    public function followerRequests($model = null)
    {
        $modelClass = $model ? (new $model)->getMorphClass() : $this->getMorphClass();

        return $this->morphToMany($modelClass, 'followable', 'followers', 'followable_id', 'follower_id')
            ->withPivot(['follower_type', 'accepted'])
            ->wherePivot('follower_type', $modelClass)
            ->wherePivot('followable_type', $this->getMorphClass())
            ->wherePivot('accepted', false)
            ->withTimestamps();
    }

    /**
     * Check if the model has requested to follow the current model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    public function hasFollowRequestFrom($model): bool
    {
        if (! $model instanceof Followable && ! $model instanceof Following) {
            return false;
        }

        return ! is_null($this->followerRequests((new $model)->getMorphClass())->find($model->getKey()));
    }

    /**
     * Accept request from a certain model to be followed.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    public function acceptFollowRequest($model): bool
    {
        if (! $model instanceof Followable && ! $model instanceof Following) {
            return false;
        }

        if (! $this->hasFollowRequestFrom($model)) {
            return false;
        }

        $this->followerRequests((new $model)->getMorphClass())->find($model->getKey())->pivot->update(['accepted' => true]);

        return true;
    }

    /**
     * Decline request from a certain model to be followed.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    public function declineFollowRequest($model): bool
    {
        if (! $model instanceof Followable && ! $model instanceof Following) {
            return false;
        }

        if (! $this->hasFollowRequestFrom($model)) {
            return false;
        }

        return (bool) $this->followerRequests((new $model)->getMorphClass())->detach($model->getKey());
    }
}
