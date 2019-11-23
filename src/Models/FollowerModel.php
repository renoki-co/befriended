<?php

namespace Rennokki\Befriended\Models;

use Illuminate\Database\Eloquent\Model;

class FollowerModel extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'followers';

    /**
     * {@inheritdoc}
     */
    protected $guarded = [];

    /**
     * The relationship for models that are followed by this model.
     *
     * @return mixed
     */
    public function followable()
    {
        return $this->morphTo();
    }

    /**
     * The relationship for models that follow this model.
     *
     * @return mixed
     */
    public function follower()
    {
        return $this->morphTo();
    }
}
