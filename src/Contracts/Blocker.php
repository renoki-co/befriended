<?php

namespace Rennokki\Befriended\Contracts;

interface Blocker
{
    /**
     * Relationship for models that this model is currently blocking.
     *
     * @param  null|\Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    public function blocking($model = null);

    /**
     * Check if the current model is blocking another model.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public function isBlocking($model): bool;

    /**
     * Check if the current model is blocking another model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    public function blocks($model): bool;

    /**
     * Block a certain model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $mode
     * @return bool
     */
    public function block($model): bool;

    /**
     * Unblock a certain model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    public function unblock($model): bool;
}
