<?php

namespace Rennokki\Befriended\Test\Models;

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
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements Following, Blocking, Liking
{
    use CanFollow, CanBeFollowed, CanBlock, CanBeBlocked, CanLike, CanBeLiked,
    LikeFilterable, BlockFilterable, FollowFilterable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
