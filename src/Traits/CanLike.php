<?php

namespace Rennokki\Befriended\Traits;

use Rennokki\Befriended\Contracts\Likeable;
use Rennokki\Befriended\Contracts\Liking;

trait CanLike
{
    /**
     * Relationship for models that this model is currently liking.
     *
     * @param  null|\Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    public function liking($model = null)
    {
        $modelClass = $model ? (new $model)->getMorphClass() : $this->getMorphClass();

        return $this->morphToMany($modelClass, 'liker', 'likers', 'liker_id', 'likeable_id')
                    ->withPivot('likeable_type')
                    ->wherePivot('likeable_type', $modelClass)
                    ->wherePivot('liker_type', $this->getMorphClass())
                    ->withTimestamps();
    }

    /**
     * Check if the current model is liking another model.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public function isLiking($model): bool
    {
        if (! $model instanceof Likeable && ! $model instanceof Liking) {
            return false;
        }

        return ! is_null($this->liking((new $model)->getMorphClass())->find($model->getKey()));
    }

    /**
     * Check if the current model is liking another model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    public function likes($model): bool
    {
        return $this->isLiking($model);
    }

    /**
     * Like a certain model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    public function like($model): bool
    {
        if (! $model instanceof Likeable && ! $model instanceof Liking) {
            return false;
        }

        if ($this->isLiking($model)) {
            return false;
        }

        $this->liking()->attach($model->getKey(), [
            'likeable_type' => (new $model)->getMorphClass(),
        ]);

        return true;
    }

    /**
     * Unlike a certain model.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return bool
     */
    public function unlike($model): bool
    {
        if (! $model instanceof Likeable && ! $model instanceof Liking) {
            return false;
        }

        if (! $this->isLiking($model)) {
            return false;
        }

        return (bool) $this->liking((new $model)->getMorphClass())->detach($model->getKey());
    }
}
