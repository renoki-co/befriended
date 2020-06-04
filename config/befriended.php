<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Models associated with the tables
    |--------------------------------------------------------------------------
    |
    | The following models are the models that interact with the migrated tables.
    | If you wish to implement your custom logic, please extend the respective class
    | and replace here the Full Class Name.
    |
    */

    'models' => [

        'follower' => \Rennokki\Befriended\Models\FollowerModel::class,

        'blocker' => \Rennokki\Befriended\Models\BlockerModel::class,

        'liker' => \Rennokki\Befriended\Models\LikerModel::class,

    ],

];
