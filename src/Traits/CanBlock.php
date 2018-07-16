<?php

namespace Rennokki\Befriended\Traits;

trait CanBlock
{
    public function blockers($model = null)
    {
        return $this->morphToMany(($model) ?: $this->getMorphClass(), 'blockable', 'blockers', 'blockable_id', 'blocker_id')
                    ->withPivot('blocker_type')
                    ->wherePivot('blocker_type', ($model) ?: $this->getMorphClass())
                    ->wherePivot('blockable_type', $this->getMorphClass());
    }

    public function blocking($model = null)
    {
        return $this->morphToMany(($model) ?: $this->getMorphClass(), 'blocker', 'blockers', 'blocker_id', 'blockable_id')
                    ->withPivot('blockable_type')
                    ->wherePivot('blockable_type', ($model) ?: $this->getMorphClass())
                    ->wherePivot('blocker_type', $this->getMorphClass());
    }

    public function isBlocking($model)
    {
        return (bool) ! is_null($this->blocking($model->getMorphClass())->find($model->getKey()));
    }

    public function block($model)
    {
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
        if (! $this->isBlocking($model)) {
            return false;
        }

        return (bool) $this->blocking($model->getMorphClass())->detach($model->getKey());
    }
}
