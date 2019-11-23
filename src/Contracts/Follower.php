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
}
