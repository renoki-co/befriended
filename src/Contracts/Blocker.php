<?php

namespace Rennokki\Befriended\Contracts;

interface Blocker
{
    public function blocking($model = null);

    public function isBlocking($model): bool;

    public function blocks($model): bool;

    public function block($model): bool;

    public function unblock($model): bool;
}
