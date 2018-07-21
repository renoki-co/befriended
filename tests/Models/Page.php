<?php

namespace Rennokki\Befriended\Test\Models;

use Illuminate\Database\Eloquent\Model;
use Rennokki\Befriended\Traits\CanLike;
use Rennokki\Befriended\Traits\CanBlock;
use Rennokki\Befriended\Contracts\Liking;
use Rennokki\Befriended\Traits\CanFollow;
use Rennokki\Befriended\Traits\CanBeLiked;
use Rennokki\Befriended\Contracts\Blocking;
use Rennokki\Befriended\Contracts\Following;
use Rennokki\Befriended\Traits\CanBeBlocked;
use Rennokki\Befriended\Traits\CanBeFollowed;
use Rennokki\Befriended\Scopes\CanFilterBlockedModels;
use Rennokki\Befriended\Scopes\CanFilterFollowingModels;
use Rennokki\Befriended\Scopes\CanFilterNonFollowingModels;

class Page extends Model implements Following, Blocking, Liking
{
    use CanFollow, CanBeFollowed, CanBlock, CanBeBlocked, CanLike, CanBeLiked, CanFilterFollowingModels, CanFilterBlockedModels,
        CanFilterNonFollowingModels;

    protected $fillable = [
        'name',
    ];
}
