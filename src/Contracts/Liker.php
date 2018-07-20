<?php

namespace Rennokki\Befriended\Contracts;

interface Liker
{
    public function liking($model = null);

    public function isLiking($model);

    public function like($model);

    public function unlinke($model);
}
