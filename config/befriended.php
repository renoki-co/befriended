<?php

return [

    /*
     * The models for tables.
     */

    'models' => [
        'follower' => \Rennokki\Befriended\Models\FollowerModel::class,
        'blocker' => \Rennokki\Befriended\Models\BlockerModel::class,
        'liker' => \Rennokki\Befriended\Models\LikerModel::class,
    ],

];
