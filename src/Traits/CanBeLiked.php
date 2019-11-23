<?php

namespace Rennokki\Befriended\Traits;

trait CanBeLiked
{
    /**
     * Relationship for models that liked this model.
     *
     * @param  null|\Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    public function likers($model = null)
    {
        $modelClass = $model ? (new $model)->getMorphClass() : $this->getMorphClass();

        return $this->morphToMany($modelClass, 'likeable', 'likers', 'likeable_id', 'liker_id')
                    ->withPivot('liker_type')
                    ->wherePivot('liker_type', $modelClass)
                    ->wherePivot('likeable_type', $this->getMorphClass())
                    ->withTimestamps();
    }
}
