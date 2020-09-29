<?php

namespace Rennokki\Befriended\Traits;

trait CanBeBlocked
{
    use HasCustomModelClass;

    /**
     * Relationship for models that blocked this model.
     *
     * @param  null|\Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    public function blockers($model = null)
    {
        $modelClass = $this->getModelMorphClass($model);

        return $this
            ->morphToMany($modelClass, 'blockable', 'blockers', 'blockable_id', 'blocker_id')
            ->withPivot('blocker_type')
            ->wherePivot('blocker_type', $modelClass)
            ->wherePivot('blockable_type', $this->getMorphClass())
            ->withTimestamps();
    }
}
