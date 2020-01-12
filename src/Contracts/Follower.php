<?php

namespace Rennokki\Befriended\Contracts;

interface Follower
{
    /**
     * Relationship for models that this model is currently following.
     *
     * @param  null|\Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    public function following($model = null);

    /**
     * Check if the current model is following another model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    public function isFollowing($model): bool;

    /**
     * Check if the current model is following another model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    public function follows($model): bool;

    /**
     * Follow a certain model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    public function follow($model): bool;

    /**
     * Unfollow a certain model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    public function unfollow($model): bool;

    /**
     * Relationship for models that this model currently has requests for.
     *
     * @param  null|\Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    public function followRequests($model = null);

    /**
     * Check if the current model has requested to follow another model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    public function hasFollowRequested($model): bool;

    /**
     * Request to follow a certain model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    public function followRequest($model): bool;

    /**
     * Cancel follow request a certain model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    public function cancelFollowRequest($model): bool;
}
