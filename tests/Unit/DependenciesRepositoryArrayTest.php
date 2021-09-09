<?php

namespace Sfneal\Dependencies\Tests\Unit;

use Sfneal\Dependencies\Dependencies;
use Sfneal\Dependencies\Tests\TestCase;

class DependenciesRepositoryArrayTest extends TestCase
{
    // todo: add python deps

    /** @test */
    public function get_dependency_collection_from_array_composer()
    {
        $collection = Dependencies::fromArray([
            'composer' => [
                'sfneal/queueables',
                'sfneal/redis-helpers',
                'sfneal/scopes',
                'sfneal/string-helpers',
                'sfneal/time-helpers',
                'sfneal/tracking',
            ],
        ])->get();

        $this->assertDependencyServiceCollection($collection, 6);
    }

    /** @test */
    public function get_dependency_collection_from_array_docker()
    {
        $collection = Dependencies::fromArray([
            'docker' => [
                'stephenneal/nginx-certbot',
                'stephenneal/nginx-flask',
                'stephenneal/nginx-laravel',
                'stephenneal/nginx-proxy',
            ],
        ])->get();

        $this->assertDependencyServiceCollection($collection, 4);
    }

    /** @test */
    public function get_dependency_collection_from_array_all()
    {
        $collection = Dependencies::fromArray([
            'composer' => [
                'sfneal/casts',
                'sfneal/currency',
                'sfneal/datum',
                'sfneal/healthy',
                'sfneal/users',
            ],
            'docker' => [
                'stephenneal/php-composer',
                'stephenneal/php-laravel',
                'stephenneal/python-aws',
                'stephenneal/python-flask',
            ],
        ])->get();

        $this->assertDependencyServiceCollection($collection, 9);
    }

    /** @test */
    public function get_dependency_collection_from_array_all_with_globals()
    {
        $globalImgShieldParams = [
            'style' => 'flat-square',
        ];
        $collection = Dependencies::fromArray([
                'composer' => [
                    'sfneal/casts',
                    'sfneal/currency',
                    'sfneal/datum',
                    'sfneal/healthy',
                    'sfneal/users',
                ],
                'docker' => [
                    'stephenneal/php-composer',
                    'stephenneal/php-laravel',
                    'stephenneal/python-aws',
                    'stephenneal/python-flask',
                ],
            ])
            ->withImgShieldGlobalParams($globalImgShieldParams)
            ->get();

        $this->assertDependencyServiceCollection($collection, 9, $globalImgShieldParams);
    }
}
