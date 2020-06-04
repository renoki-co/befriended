<?php

use Illuminate\Support\Str;

$factory->define(\Rennokki\Befriended\Test\Models\Page::class, function () {
    return [
        'name' => 'Page'.Str::random(5),
    ];
});
