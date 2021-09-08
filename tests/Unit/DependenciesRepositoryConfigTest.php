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
     * @param  Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $packages = collect($this->packageProvider())
            ->mapToGroups(function (array $params, $key) {
                [$package, $type] = $params;

                return [$type => $package];
            })
            ->toArray();

        $app['config']->set('dependencies.dependencies', $packages);
    }

    /** @test */
    public function get_dependency_collection_from_config()
    {
        $dependencies = Dependencies::fromConfig();

        $this->assertFalse($dependencies->isCached());
        $this->assertDependencyServiceCollection($dependencies->get(), $this->expectedPackagesCount());
        $this->assertTrue($dependencies->isCached());
    }

    /** @test */
    public function get_dependency_collection_from_array()
    {
        $dependencies = Dependencies::fromArray(config('dependencies.dependencies'));

        $this->assertFalse($dependencies->isCached());
        $this->assertDependencyServiceCollection($dependencies->get(), $this->expectedPackagesCount());
        $this->assertTrue($dependencies->isCached());
    }
}
