<?php

namespace Rennokki\Befriended\Traits;

use Rennokki\Befriended\Contracts\Liking;
use Rennokki\Befriended\Contracts\Likeable;

trait CanLike
{
    /**
     * Relationship for models that this model is currently liking.
     *
     * @param Model $model The model types of the results.
     * @return morphToMany The relationship.
     */
    public function liking($model = null)
    {
        return $this->morphToMany(($model) ?: $this->getMorphClass(), 'liker', 'likers', 'liker_id', 'likeable_id')
                    ->withPivot('likeable_type')
                    ->wherePivot('likeable_type', ($model) ?: $this->getMorphClass())
                    ->wherePivot('liker_type', $this->getMorphClass())
                    ->withTimestamps();
    }

    /**
     * Check if the current model is liking another model.
     *
     * @param Model $model The model which will be checked against.
     * @return bool
     */
    public function isLiking($model): bool
    {
        if (! $model instanceof Likeable && ! $model instanceof Liking) {
            return false;
        }

        return (bool) ! is_null($this->liking($model->getMorphClass())->find($model->getKey()));
    }

    /**
     * Check if the current model is liking another model.
     *
     * @param Model $model The model which will be checked against.
     * @return bool
     */
    public function likes($model): bool
    {
        return $this->isLiking($model);
    }

    /**
     * Like a certain model.
     *
     * @param Model $model The model which will be liked.
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

        $this->liking()->attach($this->getKey(), [
            'liker_id' => $this->getKey(),
            'likeable_type' => $model->getMorphClass(),
            'likeable_id' => $model->getKey(),
        ]);

        return true;
    }

    /**
     * Unlike a certain model.
     *
     * @param Model $model The model which will be unliked.
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

        return (bool) $this->liking($model->getMorphClass())->detach($model->getKey());
    }
}
