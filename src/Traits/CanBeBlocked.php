<?php

namespace Rennokki\Befriended\Traits;

trait CanBeBlocked
{
    public function blockers($model = null)
    {
        return $this->morphToMany(($model) ?: $this->getMorphClass(), 'blockable', 'blockers', 'blockable_id', 'blocker_id')
                    ->withPivot('blocker_type')
                    ->wherePivot('blocker_type', ($model) ?: $this->getMorphClass())
                    ->wherePivot('blockable_type', $this->getMorphClass());
    }
}
