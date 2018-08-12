<?php

namespace Rennokki\Befriended\Traits;

trait CanBeBlocked
{
    /**
     * Relationship for models that blocked this model.
     *
     * @param Model $model The model types of the results.
     * @return morphToMany The relationship.
     */
    public function blockers($model = null)
    {
        return $this->morphToMany(($model) ?: $this->getMorphClass(), 'blockable', 'blockers', 'blockable_id', 'blocker_id')
                    ->withPivot('blocker_type')
                    ->wherePivot('blocker_type', ($model) ?: $this->getMorphClass())
                    ->wherePivot('blockable_type', $this->getMorphClass());
                     ->withTimestamps();
    }
}
