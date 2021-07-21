<?php

namespace Sfneal\Dependencies\Tests\Unit;

use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use Sfneal\Dependencies\Dependencies;
use Sfneal\Dependencies\Services\DependenciesService;
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
    public function get_dependency_collection()
    {
        $collection = Dependencies::fromConfig()->get();

        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertSame(5, $collection->count());

        $collection->each(function (DependenciesService $service) {
            $this->assertTravisSvg($service->package, $service->travis());
            $this->assertVersionSvg($service->package, $service->version());
            $this->assertLastCommitSvg($service->package, $service->lastCommit());
            $this->assertGithubUrl($service->package, $service->gitHub());
            $this->assertTravisUrl($service->package, $service->travis());
            $this->assertVersionUrl($service->package, $service->version());
        });
    }
}
