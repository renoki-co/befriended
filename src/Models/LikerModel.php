<?php

namespace Rennokki\Befriended\Models;

use Illuminate\Database\Eloquent\Model;

class LikerModel extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'likers';

    /**
     * {@inheritdoc}
     */
    protected $guarded = [];

    /**
     * The relationship for models that are liked by this model.
     *
     * @return mixed
     */
    public function likeable()
    {
        return $this->morphTo();
    }

    /**
     * The relationship for models that like this model.
     *
     * @return mixed
     */
    public function liker()
    {
        return $this->morphTo();
    }
}
