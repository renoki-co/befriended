<?php

namespace Rennokki\Befriended\Contracts;

interface Follower
{
    public function following($model = null);

    public function isFollowing($model);

    public function follow($model);

    public function unfollow($model);
}
