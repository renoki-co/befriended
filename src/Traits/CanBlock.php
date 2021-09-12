<?php

namespace Rennokki\Befriended\Traits;

use Rennokki\Befriended\Contracts\Blockable;
use Rennokki\Befriended\Contracts\Blocking;

trait CanBlock
{
    use HasCustomModelClass;

    /**
     * Relationship for models that this model is currently blocking.
     *
     * @param  null|\Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    public function blocking($model = null)
    {
        $modelClass = $this->getModelMorphClass($model);

        return $this
            ->morphToMany($modelClass, 'blocker', 'blockers', 'blocker_id', 'blockable_id')
            ->withPivot('blockable_type')
            ->wherePivot('blockable_type', $modelClass)
            ->wherePivot('blocker_type', $this->getMorphClass())
            ->withTimestamps();
    }

    /**
     * Check if the current model is blocking another model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    public function isBlocking($model): bool
    {
        if (! $model instanceof Blockable && ! $model instanceof Blocking) {
            return false;
        }

        return ! is_null(
            $this
                ->blocking((new $model)->getMorphClass())
                ->find($model->getKey())
        );
    }

    /**
     * Check if the current model is blocking another model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    public function blocks($model): bool
    {
        return $this->isBlocking($model);
    }

    /**
     * Block a certain model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $mode
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
            'blockable_type' => (new $model)->getMorphClass(),
        ]);

        return true;
    }

    /**
     * Unblock a certain model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
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

        return (bool) $this
            ->blocking((new $model)->getMorphClass())
            ->detach($model->getKey());
    }
}
