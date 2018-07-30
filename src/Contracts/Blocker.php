<?php

namespace Rennokki\Befriended\Contracts;

interface Blocker
{
    public function blocking($model = null);

    public function isBlocking($model): float;

    public function blocks($model): float;

    public function block($model): bool;

    public function unblock($model): bool;
}
