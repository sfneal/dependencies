<?php

namespace Sfneal\Dependencies\Tests\Unit;

use Sfneal\Dependencies\Dependencies;
use Sfneal\Dependencies\Tests\TestCase;

class DependenciesRepositoryConfigEmptyTest extends TestCase
{
    /** @test */
    public function get_dependency_empty_collection()
    {
        $collection = Dependencies::fromConfig()->get();

        $this->assertDependencyServiceCollection($collection, 0);
    }

    /** @test */
    public function get_dependency_empty_collection_with_globals()
    {
        $globalImgShieldParams = [
            'style' => 'flat-square',
        ];
        $collection = Dependencies::fromConfig()
            ->withImgShieldGlobalParams($globalImgShieldParams)
            ->get();

        $this->assertDependencyServiceCollection($collection, 0, $globalImgShieldParams);
    }
}
