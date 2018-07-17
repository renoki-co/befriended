<?php

namespace Rennokki\Befriended\Contracts;

interface Followable
{
    public function followers($model = null);
}
