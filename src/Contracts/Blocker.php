<?php

namespace Rennokki\Befriended\Contracts;

interface Blocker
{
    public function blocking($model = null);

    public function isBlocking($model);

    public function blocks($model);

    public function block($model);

    public function unblock($model);
}
