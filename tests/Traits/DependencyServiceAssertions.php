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
     */
    public function assertDependencyServiceCollection(Collection $collection): void
    {
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
