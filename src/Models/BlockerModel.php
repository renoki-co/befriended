<?php

namespace Rennokki\Befriended\Models;

use Illuminate\Database\Eloquent\Model;

class BlockerModel extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'blockers';

    /**
     * {@inheritdoc}
     */
    protected $guarded = [];

    /**
     * The relationship for models that are blocked by this model.
     *
     * @return mixed
     */
    public function blockable()
    {
        return $this->morphTo();
    }

    /**
     * The relationship for models that block this model.
     *
     * @return mixed
     */
    public function blocker()
    {
        return $this->morphTo();
    }
}
