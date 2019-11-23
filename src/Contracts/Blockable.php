<?php

namespace Rennokki\Befriended\Contracts;

interface Blockable
{
    /**
     * Relationship for models that blocked this model.
     *
     * @param  null|\Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    public function blockers($model = null);
}
