<?php

namespace Rennokki\Befriended\Scopes;

trait CanFilterUnlikedModels
{
    public function scopeFilterUnlikedFor($query, $model)
    {
        $likedIds = collect($model->liking($this->getMorphClass())->get()->toArray())->pluck($model->getKeyName())->all();

        return $query->whereNotIn($this->getKeyName(), $likedIds);
    }
}
