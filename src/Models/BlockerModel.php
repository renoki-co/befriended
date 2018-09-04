<?php

namespace Rennokki\Befriended\Models;

use Illuminate\Database\Eloquent\Model;

class BlockerModel extends Model
{
    protected $table = 'blockers';
    protected $guarded = [];

    public function blockable()
    {
        return $this->morphTo();
    }

    public function blocker()
    {
        return $this->morphTo();
    }
}
