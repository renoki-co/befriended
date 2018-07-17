<?php

namespace Rennokki\Befriended\Scopes;

trait CanFilterBlockedModels
{
    public function scopeFilterBlockingsOf($query, $model)
    {
        $blockingsIds = collect($model->blocking($this->getMorphClass())->get()->toArray())->pluck($model->getKeyName())->all();

        return $query->whereNotIn($this->getKeyName(), $blockingsIds);
    }
}
