<?php

namespace Rennokki\Befriended\Test;

use Rennokki\Befriended\Test\Models\User;
use Rennokki\Befriended\Models\LikerModel;
use Rennokki\Befriended\Test\Models\Pages;
use Rennokki\Befriended\Models\BlockerModel;
use Rennokki\Befriended\Models\FollowerModel;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    public function setUp()
    {
        parent::setUp();

        $this->resetDatabase();

        $this->loadLaravelMigrations(['--database' => 'sqlite']);
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->withFactories(__DIR__.'/../database/factories');

        $this->artisan('migrate', ['--database' => 'sqlite']);
    }

    protected function getPackageProviders($app)
    {
        return [
            \Rennokki\Befriended\BefriendedServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver'   => 'sqlite',
            'database' => __DIR__.'/database.sqlite',
            'prefix'   => '',
        ]);
        $app['config']->set('auth.providers.users.model', User::class);
        $app['config']->set('auth.providers.pages.model', Page::class);
        $app['config']->set('app.key', 'wslxrEFGWY6GfGhvN9L3wH3KSRJQQpBD');
        $app['config']->set('befriended.models.follower', FollowerModel::class);
        $app['config']->set('befriended.models.blocker', BlockerModel::class);
        $app['config']->set('befriended.models.liker', LikerModel::class);
    }

    protected function resetDatabase()
    {
        file_put_contents(__DIR__.'/database.sqlite', null);
    }
}
