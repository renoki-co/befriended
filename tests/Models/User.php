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
use Rennokki\Befriended\Scopes\CanFilterBlockedModels;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Rennokki\Befriended\Scopes\CanFilterFollowingModels;
use Rennokki\Befriended\Scopes\CanFilterUnfollowedModels;

class User extends Authenticatable implements Following, Blocking, Liking
{
    use CanFollow, CanBeFollowed, CanBlock, CanBeBlocked, CanLike, CanBeLiked, CanFilterFollowingModels, CanFilterBlockedModels,
        CanFilterUnfollowedModels;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
