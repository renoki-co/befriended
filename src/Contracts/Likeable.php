<?php

namespace Rennokki\Befriended\Contracts;

interface Likeable
{
    /**
     * Relationship for models that liked this model.
     *
     * @param  null|\Illuminate\Database\Eloquent\Model  $model
     * @return mixed
     */
    public function likers($model = null);
}
