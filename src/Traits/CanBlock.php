<?php

namespace Rennokki\Befriended\Traits;

use Rennokki\Befriended\Contracts\Blockable;
use Rennokki\Befriended\Contracts\Blocking;

trait CanBlock
{
    /**
     * Relationship for models that this model is currently blocking.
     *
     * @param Model $model The model types of the results.
     * @return morphToMany The relationship.
     */
    public function blocking($model = null)
    {
        return $this->morphToMany(($model) ?: $this->getMorphClass(), 'blocker', 'blockers', 'blocker_id', 'blockable_id')
                    ->withPivot('blockable_type')
                    ->wherePivot('blockable_type', ($model) ?: $this->getMorphClass())
                    ->wherePivot('blocker_type', $this->getMorphClass())
                    ->withTimestamps();
    }

    /**
     * Check if the current model is blocking another model.
     *
     * @param Model $model The model which will be checked against.
     * @return bool
     */
    public function isBlocking($model): bool
    {
        if (! $model instanceof Blockable && ! $model instanceof Blocking) {
            return false;
        }

        return (bool) ! is_null($this->blocking($model->getMorphClass())->find($model->getKey()));
    }

    /**
     * Check if the current model is blocking another model.
     *
     * @param Model $model The model which will be checked against.
     * @return bool
     */
    public function blocks($model): bool
    {
        return $this->isBlocking($model);
    }

    /**
     * Block a certain model.
     *
     * @param Model $model The model which will be blocked.
     * @return bool
     */
    public function block($model): bool
    {
        if (! $model instanceof Blockable && ! $model instanceof Blocking) {
            return false;
        }

        if ($this->isBlocking($model)) {
            return false;
        }

        $this->blocking()->attach($model->getKey(), [
            'blockable_type' => $model->getMorphClass(),
        ]);

        return true;
    }

    /**
     * Unblock a certain model.
     *
     * @param Model $model The model which will be unblocked.
     * @return bool
     */
    public function unblock($model): bool
    {
        if (! $model instanceof Blockable && ! $model instanceof Blocking) {
            return false;
        }

        if (! $this->isBlocking($model)) {
            return false;
        }

        return (bool) $this->blocking($model->getMorphClass())->detach($model->getKey());
    }
}
