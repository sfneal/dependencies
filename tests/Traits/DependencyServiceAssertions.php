<?php

namespace Sfneal\Dependencies\Tests\Traits;

use Illuminate\Support\Collection;
use Sfneal\Dependencies\Services\DependenciesService;

trait DependencyServiceAssertions
{
    /**
     * Execute `DependencyService` assertions.
     *
     * @param Collection $collection
     * @param int $expected
     */
    public function assertDependencyServiceCollection(Collection $collection, int $expected): void
    {
        $this->assertInstanceOf(Collection::class, $collection);
        $this->assertSame($expected, $collection->count());

        $collection->each(function (DependenciesService $service) {
            $this->assertTravisSvg($service->packageGitubName, $service->travis());
            $this->assertVersionSvg($service->package, $service->version());
            $this->assertLastCommitSvg($service->packageGitubName, $service->lastCommit());
            $this->assertGithubUrl($service->packageGitubName, $service->gitHub());
            $this->assertTravisUrl($service->packageGitubName, $service->travis());
            $this->assertVersionUrl($service->package, $service->version());
        });
    }
}
