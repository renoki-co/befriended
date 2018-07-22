<?php

namespace Rennokki\Befriended\Models;

use Illuminate\Database\Eloquent\Model;

class BlockerModel extends Model
{
    protected $table = 'blockers';
    protected $fillable = [
        'blockable_id', 'blockable_type',
        'blocker_id', 'blocker_type',
    ];

    public function blockable()
    {
        return $this->morphTo();
    }

    public function blocker()
    {
        return $this->morphTo();
    }
}
