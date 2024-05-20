<?php

namespace Sfneal\Dependencies\Tests\Feature;

use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use Sfneal\Dependencies\Tests\TestCase;
use Sfneal\Dependencies\Utils\ComposerRequirements;

class ComposerRequirementsTest extends TestCase
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
        $deps = (new ComposerRequirements())->get();

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
            'josiasmontag/laravel-redis-mock',
            'phpunit/phpunit',
            'orchestra/testbench',
            'predis/predis',
            'guzzlehttp/guzzle',
        ];
        $deps = (new ComposerRequirements(true))->get();

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
        $values = array_values($dependencies->toArray());
        $this->assertSame(sort($expected), sort($values));
    }
}
