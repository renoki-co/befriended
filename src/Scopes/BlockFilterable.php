<?php

namespace Rennokki\Befriended\Scopes;

use Rennokki\Befriended\Contracts\Blocker;
use Rennokki\Befriended\Contracts\Blocking;

trait BlockFilterable
{
    /**
     * Evict any records that the model blocked.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithoutBlockingsOf($query, $model)
    {
        if (! $model instanceof Blocker && ! $model instanceof Blocking) {
            return $query;
        }

        $blockingsIds = $model
            ->blocking($this->getMorphClass())
            ->get()
            ->pluck($model->getKeyName())
            ->toArray();

        return $query->whereNotIn(
            $this->getKeyName(), $blockingsIds
        );
    }

    /**
     * Alias to scopeWithoutBlockingsOf.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterBlockingsOf($query, $model)
    {
        return $this->scopeWithoutBlockingsOf($query, $model);
    }
}
