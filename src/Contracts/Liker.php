<?php

namespace Rennokki\Befriended\Contracts;

interface Liker
{
    /**
     * Relationship for models that this model is currently liking.
     *
     * @param  null|\Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    public function liking($model = null);

    /**
     * Check if the current model is liking another model.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public function isLiking($model): bool;

    /**
     * Check if the current model is liking another model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    public function likes($model): bool;

    /**
     * Like a certain model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    public function like($model): bool;

    /**
     * Unlike a certain model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    public function unlike($model): bool;
}
