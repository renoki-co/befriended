<?php

namespace Rennokki\Befriended\Contracts;

interface Likeable
{
    public function likers($model = null);
}
