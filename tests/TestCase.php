<?php

namespace Rennokki\Befriended\Test;

use Orchestra\Testbench\TestCase as Orchestra;
use Rennokki\Befriended\Models\BlockerModel;
use Rennokki\Befriended\Models\FollowerModel;
use Rennokki\Befriended\Models\LikerModel;
use Rennokki\Befriended\Test\Models\Page;
use Rennokki\Befriended\Test\Models\User;

abstract class TestCase extends Orchestra
{
    /**
     * Set up the tests.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->resetDatabase();

        $this->loadLaravelMigrations(['--database' => 'sqlite']);

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        $this->withFactories(__DIR__.'/database/factories');

        $this->artisan('migrate', ['--database' => 'sqlite']);
    }

    /**
     * Get the package providers for tests.
     *
     * @param  mixed  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            \Rennokki\Befriended\BefriendedServiceProvider::class,
        ];
    }

    /**
     * Set up the environment.
     *
     * @param  mixed  $app
     * @return void
     */
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

    /**
     * Reset the database.
     *
     * @return void
     */
    protected function resetDatabase()
    {
        file_put_contents(__DIR__.'/database.sqlite', null);
    }
}
