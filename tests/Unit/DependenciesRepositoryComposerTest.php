<?php

namespace Sfneal\Dependencies\Tests\Unit;

use Illuminate\Foundation\Application;
use Sfneal\Dependencies\Dependencies;
use Sfneal\Dependencies\Tests\TestCase;
use Sfneal\Dependencies\Utils\ComposerDependencies;

class DependenciesRepositoryComposerTest extends TestCase
{
    /**
     * Define environment setup.
     *
     * @param  Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('dependencies.composer_json_path', __DIR__.'/../../composer.json');
    }

    /** @test */
    public function get_dependency_collection()
    {
        $collection = Dependencies::fromComposer()->get();

        $this->assertDependencyServiceCollection($collection, (new ComposerDependencies())->get()->count());
    }

    /** @test */
    public function get_dependency_collection_with_globals()
    {
        $globalImgShieldParams = [
            'style' => 'flat-square',
        ];
        $collection = Dependencies::fromComposer()
            ->withImgShieldGlobalParams($globalImgShieldParams)
            ->get();

        $this->assertDependencyServiceCollection($collection, (new ComposerDependencies())->get()->count(), $globalImgShieldParams);
    }
}
