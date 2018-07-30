<?php

namespace Rennokki\Befriended\Contracts;

interface Follower
{
    public function following($model = null);

    public function isFollowing($model): bool;

    public function follows($model): bool;

    public function follow($model): bool;

    public function unfollow($model): bool;
}
