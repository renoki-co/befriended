<?php

namespace Rennokki\Befriended\Contracts;

interface Followable
{
    /**
     * Relationship for models that followed this model.
     *
     * @param  null|\Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    public function followers($model = null);

    /**
     * Relationship for models that has requested to follow this model.
     *
     * @param  null|\Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    public function followerRequests($model = null);

    /**
     * Check if the model has requested to follow the current model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    public function hasFollowRequestFrom($model): bool;

    /**
     * Accept request from a certain model to be followed.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    public function acceptFollowRequest($model): bool;

    /**
     * Decline request from a certain model to be followed.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    public function declineFollowRequest($model): bool;
}
