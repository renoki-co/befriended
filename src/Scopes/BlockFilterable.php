<?php

namespace Rennokki\Befriended\Scopes;

trait BlockFilterable
{
    public function scopeWithoutBlockingsOf($query, $model)
    {
        if (! $model instanceof Blockable && ! $model instanceof Blocking) {
            return $query;
        }

        $blockingsIds = collect($model->blocking($this->getMorphClass())->get()->toArray())->pluck($model->getKeyName())->all();

        return $query->whereNotIn($this->getKeyName(), $blockingsIds);
    }

    public function scopeFilterBlockingsOf($query, $model)
    {
        return $this->scopeWithoutBlockingsOf($query, $model);
    }
}