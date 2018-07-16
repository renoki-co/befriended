<?php

namespace Rennokki\Befriended\Test\Models;

use Rennokki\Befriended\Traits\CanBlock;
use Rennokki\Befriended\Traits\CanFollow;
use Rennokki\Befriended\Interfaces\Blocking;
use Rennokki\Befriended\Interfaces\Following;
use Rennokki\Befriended\Traits\CanFilterBlocking;
use Rennokki\Befriended\Traits\CanFilterFollowers;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements Following, Blocking
{
    use CanFollow, CanBlock, CanFilterFollowers, CanFilterBlocking;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
