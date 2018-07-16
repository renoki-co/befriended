<?php

namespace Rennokki\Befriended\Interfaces;

interface Following
{
    public function followers($model = null);

    public function following($model = null);

    public function isFollowing($model);

    public function follow($model);

    public function unfollow($model);
}
