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
                    ->withPivot('follower_type')
                    ->wherePivot('follower_type', $modelClass)
                    ->wherePivot('followable_type', $this->getMorphClass())
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

        return $this->morphToMany($modelClass, 'follow_requestable', 'follow_requests', 'follow_requestable_id', 'follow_requester_id')
            ->withPivot('follow_requester_type')
            ->wherePivot('follow_requester_type', $modelClass)
            ->wherePivot('follow_requestable_type', $this->getMorphClass())
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
    public function AcceptFollowRequest($model): bool
    {
        if (! $model instanceof Followable && ! $model instanceof Following) {
            return false;
        }

        if (! $this->hasFollowRequestFrom($model)) {
            return false;
        }

        $this->followerRequests((new $model)->getMorphClass())->detach($model->getKey());

        $this->followers()->attach($model->getKey(), [
            'follower_type' => (new $model)->getMorphClass(),
        ]);

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
