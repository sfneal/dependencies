<?php

namespace Sfneal\Dependencies\Tests;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Sfneal\Dependencies\Providers\DependenciesServiceProvider;
use Sfneal\Dependencies\Tests\Traits\SvgAssertions;
use Sfneal\Dependencies\Tests\Traits\UrlAssertions;

abstract class TestCase extends OrchestraTestCase
{
    use SvgAssertions;
    use UrlAssertions;

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

    /**
     * Retrieve an array of packages.
     *
     * @return array
     */
    public function packageProvider(): array
    {
        return [
            ['sfneal/actions'],
            ['sfneal/aws-s3-helpers'],
            ['sfneal/laravel-helpers'],
            ['laravel/framework'],
            ['spatie/laravel-view-models'],
        ];
    }
}
