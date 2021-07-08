<?php

namespace Sfneal\Dependencies\Tests;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Sfneal\Dependencies\Providers\DependenciesServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * Register package service providers.
     *
     * @param Application $app
     * @return array|string
     */
    protected function getPackageProviders($app)
    {
        return [
            DependenciesServiceProvider::class,
        ];
    }
}
