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
     * @param  Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('dependencies.composer_json_path', __DIR__.'/../../composer.json');
    }

    /** @test */
    public function get_composer_dependencies()
    {
        $expected = [
            'illuminate/support',
            'sfneal/caching',
            'sfneal/laravel-helpers',
            'sfneal/string-helpers',
        ];
        $deps = (new ComposerDependencies())->get();

        $this->assertComposerDependencies($expected, $deps);
    }

    /** @test */
    public function get_composer_dependencies_dev()
    {
        $expected = [
            'illuminate/support',
            'sfneal/caching',
            'sfneal/laravel-helpers',
            'sfneal/string-helpers',
            'phpunit/phpunit',
            'orchestra/testbench',
            'scrutinizer/ocular',
        ];
        $deps = (new ComposerDependencies(true))->get();

        $this->assertComposerDependencies($expected, $deps);
    }

    /**
     * Execute assertions on a `ComposerDependencies` collection.
     *
     * @param  array  $expected
     * @param  Collection  $dependencies
     */
    public function assertComposerDependencies(array $expected, Collection $dependencies): void
    {
        $this->assertInstanceOf(Collection::class, $dependencies);
        $this->assertCount(count($expected), $dependencies);

        // use `array_values()` to reindex array keys
        $this->assertSame($expected, array_values($dependencies->toArray()));
    }
}
