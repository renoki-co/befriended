<?php

namespace Rennokki\Befriended\Traits;

trait CanFilterBlocking
{
    public function scopeFilterBlockingsOf($query, $model)
    {
        $blockingsIds = collect($model->blocking($this->getMorphClass())->get()->toArray())->pluck($model->getKeyName())->all();

        return $query->whereNotIn($this->getKeyName(), $blockingsIds);
    }
}
