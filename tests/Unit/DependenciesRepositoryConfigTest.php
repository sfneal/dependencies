<?php

namespace Sfneal\Dependencies\Tests\Unit;

use Illuminate\Foundation\Application;
use Sfneal\Dependencies\Dependencies;
use Sfneal\Dependencies\Tests\TestCase;

class DependenciesRepositoryConfigTest extends TestCase
{
    /**
     * Define environment setup.
     *
     * @param Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set(
            'dependencies.dependencies.composer',
            [
                'sfneal/actions',
                'sfneal/aws-s3-helpers',
                'sfneal/laravel-helpers',
                'laravel/framework',
                'spatie/laravel-view-models',
            ]
        );
    }

    /** @test */
    public function get_dependency_collection_from_config()
    {
        $collection = Dependencies::fromConfig()->get();

        $this->assertDependencyServiceCollection($collection, 5);
    }
}
