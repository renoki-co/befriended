<?php

namespace Rennokki\Befriended\Contracts;

interface Liker
{
    public function liking($model = null);

    public function isLiking($model): bool;

    public function likes($model): bool;

    public function like($model): bool;

    public function unlike($model): bool;
}
