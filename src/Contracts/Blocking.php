<?php

namespace Rennokki\Befriended\Contracts;

interface Blocking
{
    public function blockers($model = null);

    public function blocking($model = null);

    public function isBlocking($model);

    public function block($model);

    public function unblock($model);
}
