<?php

namespace Rennokki\Befriended\Test\Models;

use Illuminate\Database\Eloquent\Model;
use Rennokki\Befriended\Traits\CanBlock;
use Rennokki\Befriended\Traits\CanFollow;
use Rennokki\Befriended\Contracts\Blocking;
use Rennokki\Befriended\Contracts\Following;
use Rennokki\Befriended\Traits\CanFilterBlocking;
use Rennokki\Befriended\Traits\CanFilterFollowers;

class Page extends Model implements Following, Blocking
{
    use CanFollow, CanBlock, CanFilterFollowers, CanFilterBlocking;

    protected $fillable = [
        'name',
    ];
}
