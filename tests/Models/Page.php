<?php

namespace Rennokki\Befriended\Test\Models;

use Illuminate\Database\Eloquent\Model;
use Rennokki\Befriended\Traits\CanBlock;
use Rennokki\Befriended\Traits\CanFollow;
use Rennokki\Befriended\Traits\CanBeBlocked;
use Rennokki\Befriended\Traits\CanBeFollowed;
use Rennokki\Befriended\Contracts\Blocking;
use Rennokki\Befriended\Contracts\Following;
use Rennokki\Befriended\Scopes\CanFilterBlocking;
use Rennokki\Befriended\Scopes\CanFilterFollowers;

class Page extends Model implements Following, Blocking
{
    use CanFollow, CanBeFollowed, CanBlock, CanBeBlocked, CanFilterFollowers, CanFilterBlocking;

    protected $fillable = [
        'name',
    ];
}
