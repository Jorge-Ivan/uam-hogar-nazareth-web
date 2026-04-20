<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    protected function refreshApplication(): void
    {
        parent::refreshApplication();

        // Redirect all DB traffic to the isolated test database before RefreshDatabase runs
        $this->app['config']->set('database.connections.mysql.database', 'hogarnazareth_test');
        $this->app['db']->purge('mysql');
        $this->app['db']->reconnect('mysql');
    }
}
