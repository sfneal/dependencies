<?php

namespace Sfneal\Dependencies\Tests\Unit;

use Illuminate\Support\Collection;
use Sfneal\Dependencies\Dependencies;
use Sfneal\Dependencies\Tests\TestCase;

class DependenciesRepositoryConfigEmptyTest extends TestCase
{
    /** @test */
    public function get_dependency_empty_collection()
    {
        $collection = Dependencies::fromConfig()->get();

        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertSame(0, $collection->count());
    }
}
