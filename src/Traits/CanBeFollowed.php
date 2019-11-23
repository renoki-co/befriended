<?php

namespace Rennokki\Befriended\Traits;

trait CanBeFollowed
{
    /**
     * Relationship for models that followed this model.
     *
     * @param  null|\Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    public function followers($model = null)
    {
        $modelClass = $model ? (new $model)->getMorphClass() : $this->getMorphClass();

        return $this->morphToMany($modelClass, 'followable', 'followers', 'followable_id', 'follower_id')
                    ->withPivot('follower_type')
                    ->wherePivot('follower_type', $modelClass)
                    ->wherePivot('followable_type', $this->getMorphClass())
                    ->withTimestamps();
    }
}
