<?php

namespace Rennokki\Befriended\Contracts;

interface Followable
{
    /**
     * Relationship for models that followed this model.
     *
     * @param  null|\Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    public function followers($model = null);
}
