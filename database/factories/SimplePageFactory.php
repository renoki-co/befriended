<?php
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\Rennokki\Befriended\Test\Models\SimplePage::class, function () {
    return [
        'name' => 'Page'.str_random(5),
    ];
});
