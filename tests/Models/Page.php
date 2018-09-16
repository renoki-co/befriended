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
use Rennokki\Befriended\Scopes\LikeFilterable;
use Rennokki\Befriended\Scopes\BlockFilterable;
use Rennokki\Befriended\Scopes\FollowFilterable;

class Page extends Model implements Following, Blocking, Liking
{
    use CanFollow, CanBeFollowed, CanBlock, CanBeBlocked, CanLike, CanBeLiked,
    LikeFilterable, BlockFilterable, FollowFilterable;

    protected $fillable = [
        'name',
    ];
}
