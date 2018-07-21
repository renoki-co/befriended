<?php

namespace Rennokki\Befriended\Traits;

use Rennokki\Befriended\Contracts\Blocker;
use Rennokki\Befriended\Contracts\Blocking;

trait CanBlock
{
    public function blocking($model = null)
    {
        return $this->morphToMany(($model) ?: $this->getMorphClass(), 'blocker', 'blockers', 'blocker_id', 'blockable_id')
                    ->withPivot('blockable_type')
                    ->wherePivot('blockable_type', ($model) ?: $this->getMorphClass())
                    ->wherePivot('blocker_type', $this->getMorphClass());
    }

    public function isBlocking($model)
    {
        if (! $model instanceof Blocker && ! $model instanceof Blocking) {
            return false;
        }

        return (bool) ! is_null($this->blocking($model->getMorphClass())->find($model->getKey()));
    }

    public function blocks($model)
    {
        return $this->isBlocking($model);
    }

    public function block($model)
    {
        if (! $model instanceof Blocker && ! $model instanceof Blocking) {
            return false;
        }

        if ($this->isBlocking($model)) {
            return false;
        }

        $this->blocking()->attach($this->getKey(), [
            'blocker_id' => $this->getKey(),
            'blockable_type' => $model->getMorphClass(),
            'blockable_id' => $model->getKey(),
        ]);

        return true;
    }

    public function unblock($model)
    {
        if (! $model instanceof Blocker && ! $model instanceof Blocking) {
            return false;
        }

        if (! $this->isBlocking($model)) {
            return false;
        }

        return (bool) $this->blocking($model->getMorphClass())->detach($model->getKey());
    }
}
