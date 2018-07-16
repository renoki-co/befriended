<?php

namespace Rennokki\Befriended\Test\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Rennokki\Befriended\Traits\CanFollow;
use Rennokki\Befriended\Traits\CanBlock;
use Rennokki\Befriended\Traits\CanFilterFollowers;
use Rennokki\Befriended\Traits\CanFilterBlocking;

use Rennokki\Befriended\Interfaces\Following;
use Rennokki\Befriended\Interfaces\Blocking;

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
