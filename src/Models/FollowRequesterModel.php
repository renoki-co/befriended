<?php

namespace Rennokki\Befriended\Models;

use Illuminate\Database\Eloquent\Model;

class FollowRequesterModel extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'follow_requests';

    /**
     * {@inheritdoc}
     */
    protected $guarded = [];

    /**
     * The relationship for models that are follow requested by this model.
     *
     * @return mixed
     */
    public function followRequestable()
    {
        return $this->morphTo();
    }

    /**
     * The relationship for models that has requested to follow this model.
     *
     * @return mixed
     */
    public function followRequester()
    {
        return $this->morphTo();
    }
}
