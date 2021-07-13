<?php


namespace Sfneal\Dependencies\Tests\Unit;


use Illuminate\Support\Collection;
use Sfneal\Dependencies\DependenciesRepository;
use Sfneal\Dependencies\Services\DependenciesService;
use Sfneal\Dependencies\Tests\TestCase;

class DependenciesRepositoryComposerTest extends TestCase
{
    /** @test */
    public function get_dependency_collection()
    {
        $repo = new DependenciesRepository(true);
        $collection = $repo->get();

        $this->assertInstanceOf(Collection::class, $collection);

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
