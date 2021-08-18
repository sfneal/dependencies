<?php

namespace Sfneal\Dependencies\Tests\Feature;

use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use Sfneal\Dependencies\Tests\TestCase;
use Sfneal\Dependencies\Utils\ComposerDependencies;

class ComposerDependencyTest extends TestCase
{
    /**
     * Define environment setup.
     *
     * @param Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('dependencies.composer_json_path', __DIR__.'/../../composer.json');
    }

    /** @test */
    public function get_composer_dependencies()
    {
        // todo: change to 1D array and add 'composer' values later
        $expected = [
            'illuminate/support' => 'composer',
            'sfneal/caching' => 'composer',
            'sfneal/laravel-helpers' => 'composer',
            'sfneal/string-helpers' => 'composer',
        ];
        $deps = (new ComposerDependencies())->get();

        $this->assertComposerDependencies($expected, $deps);
    }

    /** @test */
    public function get_composer_dependencies_dev()
    {
        // todo: change to 1D array and add 'composer' values later
        $expected = [
            'illuminate/support' => 'composer',
            'sfneal/caching' => 'composer',
            'sfneal/laravel-helpers' => 'composer',
            'sfneal/string-helpers' => 'composer',
            'phpunit/phpunit' => 'composer',
            'orchestra/testbench' => 'composer',
            'scrutinizer/ocular' => 'composer',

        ];
        $deps = (new ComposerDependencies(true))->get();

        $this->assertComposerDependencies($expected, $deps);
    }

    /**
     * Execute assertions on a `ComposerDependencies` collection.
     *
     * @param array $expected
     * @param Collection $dependencies
     */
    public function assertComposerDependencies(array $expected, Collection $dependencies): void
    {
        $this->assertInstanceOf(Collection::class, $dependencies);
        $this->assertCount(count($expected), $dependencies);
        $this->assertSame($expected, $dependencies->toArray());
    }
}
