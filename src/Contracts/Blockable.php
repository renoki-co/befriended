<?php

namespace Rennokki\Befriended\Contracts;

interface Blockable
{
    public function blockers($model = null);
}
