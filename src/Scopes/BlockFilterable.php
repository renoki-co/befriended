<?php

namespace Rennokki\Befriended\Scopes;

use Rennokki\Befriended\Contracts\Blocker;
use Rennokki\Befriended\Contracts\Blocking;

trait BlockFilterable
{
    public function scopeWithoutBlockingsOf($query, $model)
    {
        if (! $model instanceof Blocker && ! $model instanceof Blocking) {
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
