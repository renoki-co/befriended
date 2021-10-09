<?php

namespace Rennokki\Befriended\Test\Models;

use Illuminate\Database\Eloquent\Model;

class Blocker extends Model
{
    protected $table = 'blockers';

    protected $fillable = [
        'blockable_id', 'blockable_type', 'blocker_id', 'blocker_type',
    ];
}
